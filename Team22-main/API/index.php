<?php

require_once 'config.php';

// Set the content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Token-Auth, Authorization');
ob_start();
// Get the current URL path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = rtrim($request_uri, '/'); // Remove trailing slash

// Split the path into segments
$path_segments = explode('/', $request_uri);
$endpoint = $path_segments[2];


// Check if the user is authenticated and authorized
$is_authenticated = authenticate(); // Implement your authentication logic here
$is_authorized = authorize($endpoint, $_SERVER['REQUEST_METHOD']); // Implement your authorization logic here


function getWithFilters($pdo, $filters, $table) {
    // Construct the SQL query with filters
    $sql = 'SELECT * FROM ' . $table;
    if (!empty($filters)) {
        $sql .= ' WHERE ' . implode(' AND ', $filters);
    }

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare($sql);
    $params = [];
    foreach ($filters as $filter) {
        // Extract the value of each filter and add it to the parameters array
        $params[] = $_GET[explode(' ', $filter)[0]]; // Extracting the filter name
    }
    $stmt->execute($params);

    // Fetch and return the results as JSON
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

switch ($endpoint) {
    case 'users':
        // Endpoint for retrieving all users
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];

            // Check if UserID filter is provided
            if (isset($_GET['UserID'])) {
                $filters[] = "UserID = ?";
            }

            // Check if Username filter is provided
            if (isset($_GET['Username'])) {
                $filters[] = "Username = ?";
            }

            // Check if Email filter is provided
            if (isset($_GET['Email'])) {
                $filters[] = "Email = ?";
            }

            if (isset($_GET['Password'])) {
                $filters[] = "Password = ?";
            }

            // Check if UserType filter is provided
            if (isset($_GET['UserType'])) {
                $filters[] = "UserType = ?";
            }


            $result = getWithFilters($pdo, $filters, "users");
            echo json_encode($result);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized || TRUE) {
                // Extract data from query parameters
                $username = $_GET['Username'] ?? '';
                $email = $_GET['email'] ?? '';
                $password = $_GET['password'] ?? '';
                $userType = $_GET['userType'] ?? '';

                // Perform input validation and sanitization
                $username = filter_var($username, FILTER_SANITIZE_STRING);
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $password = password_hash($password, PASSWORD_DEFAULT);

                // Check if any required fields are missing
                if (empty($username) || empty($email) || empty($password) || empty($userType)) {
                    http_response_code(400); // Bad Request
                    echo "username: $username, email: $email, password: $password, userType: $userType";
                    echo json_encode(["error" => "Missing required fields"]);
                    break;
                }

                // Insert the new user into the database
                $stmt = $pdo->prepare("INSERT INTO users (Username, Email, Password, UserType) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $password, $userType]);
                $insertedId = $pdo->lastInsertId();

                $response = [
                    'message' => 'User created successfully',
                    'userId' => $insertedId
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'projects':
        // Endpoint for retrieving all projects
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $stmt = $pdo->query('SELECT * FROM projects');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        }
        // Endpoint for creating a new project
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new project
                // ... (same as the previous example)
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'tasks':
        // Endpoint for retrieving all tasks
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if TaskID filter is provided
            if (isset($_GET['TaskID'])) {
                $filters[] = "TaskID = ?";
            }
            // Check if TaskName filter is provided
            if (isset($_GET['TaskName'])) {
                $filters[] = "TaskName = ?";
            }
            // Check if TaskStatus filter is provided
            if (isset($_GET['TaskStatus'])) {
                $filters[] = "TaskStatus = ?";
            }
            // Check if IsPrivate filter is provided
            if (isset($_GET['IsPrivate'])) {
                $filters[] = "IsPrivate = ?";
            }
            $result = getWithFilters($pdo, $filters, "tasks");
            echo json_encode($result);
        }
        // Endpoint for creating a new task
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new task
                $data = json_decode(file_get_contents('php://input'), true);
                $taskName = $data['taskName'];
                $taskDescription = $data['taskDescription'];
                $taskStatus = $data['taskStatus'];
                $dueDate = $data['dueDate'];
                $isPrivate = $data['isPrivate'] ?? 0;
                $taskDuration = $data['taskDuration'];
                $colour = $data['colour'];

                $stmt = $pdo->prepare("INSERT INTO tasks (TaskName, TaskDescription, TaskStatus, DueDate, IsPrivate, TaskDuration, Colour) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$taskName, $taskDescription, $taskStatus, $dueDate, $isPrivate, $taskDuration, $colour]);
                $insertedId = $pdo->lastInsertId();

                $response = [
                    'message' => 'Task created successfully',
                    'taskId' => $insertedId
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'usertasks':
        // Endpoint for retrieving all user-task mappings
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if UserID filter is provided
            if (isset($_GET['UserID'])) {
                $filters[] = "UserID = ?";
            }
            // Check if TaskID filter is provided
            if (isset($_GET['TaskID'])) {
                $filters[] = "TaskID = ?";
            };
            $result = getWithFilters($pdo, $filters, "usertasks");
            echo json_encode($result);
        }
        // Endpoint for creating a new user-task mapping
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new user-task mapping
                $data = json_decode(file_get_contents('php://input'), true);
                $userId = $data['userId'];
                $taskId = $data['taskId'];

                $stmt = $pdo->prepare("INSERT INTO usertasks (UserID, TaskID) VALUES (?, ?)");
                $stmt->execute([$userId, $taskId]);

                $response = [
                    'message' => 'User-task mapping created successfully'
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'userprojects':
        // Endpoint for retrieving all user-project mappings
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if UserID filter is provided
            if (isset($_GET['UserID'])) {
                $filters[] = "UserID = ?";
            }
            // Check if ProjectID filter is provided
            if (isset($_GET['ProjectID'])) {
                $filters[] = "ProjectID = ?";
            }
            $result = getWithFilters($pdo, $filters, "userprojects");
            echo json_encode($result);
        }
        // Endpoint for creating a new user-project mapping
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new user-project mapping
                $data = json_decode(file_get_contents('php://input'), true);
                $userId = $data['userId'];
                $projectId = $data['projectId'];
                $isTeamLeader = $data['isTeamLeader'] ?? 0;

                $stmt = $pdo->prepare("INSERT INTO userprojects (UserID, ProjectID, IsTeamLeader) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $projectId, $isTeamLeader]);

                $response = [
                    'message' => 'User-project mapping created successfully'
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'taskprojects':
        // Endpoint for retrieving all task-project mappings
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if TaskID filter is provided
            if (isset($_GET['TaskID'])) {
                $filters[] = "TaskID = ?";
            }
            // Check if ProjectID filter is provided
            if (isset($_GET['ProjectID'])) {
                $filters[] = "ProjectID = ?";
            }
            $result = getWithFilters($pdo, $filters, "taskprojects");
            echo json_encode($result);
        }
        // Endpoint for creating a new task-project mapping
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new task-project mapping
                $data = json_decode(file_get_contents('php://input'), true);
                $taskId = $data['taskId'];
                $projectId = $data['projectId'];

                $stmt = $pdo->prepare("INSERT INTO taskprojects (TaskID, ProjectID) VALUES (?, ?)");
                $stmt->execute([$taskId, $projectId]);

                $response = [
                    'message' => 'Task-project mapping created successfully'
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    // TEAM MESSAGE ENDPOINTS


    case 'usergroups':
        // Endpoint for retrieving all user-group mappings
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if UserID filter is provided
            if (isset($_GET['UserID'])) {
                $filters[] = "UserID = ?";
            }
            // Check if GroupID filter is provided
            if (isset($_GET['GroupID'])) {
                $filters[] = "GroupID = ?";
            }
            $result = getWithFilters($pdo, $filters, "usergroups");
            echo json_encode($result);
        }
        // Endpoint for creating a new user-group mapping
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new user-group mapping
                $data = json_decode(file_get_contents('php://input'), true);
                $userId = $data['userId'];
                $groupId = $data['groupId'];

                $stmt = $pdo->prepare("INSERT INTO usergroups (UserID, GroupID) VALUES (?, ?)");
                $stmt->execute([$userId, $groupId]);

                $response = [
                    'message' => 'User-group mapping created successfully'
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove || TRUE once you've implemented authentication and authorization
                // Handle the PUT request for updating an existing user-group record
                $groupID = $_GET['groupID'];
                $userID = $_GET['userID'];

                // Check if the required data is present
                if (isset($_GET['is_newChat']) || isset($_GET['isOpened'])) {
                    $updateFields = [];
                    $updateValues = [];

                    if (isset($_GET['is_newChat'])) {
                        $updateFields[] = "is_newChat = ?";
                        $updateValues[] = $_GET['is_newChat'];
                    }

                    if (isset($_GET['isOpened'])) {
                        $updateFields[] = "isOpened = ?";
                        $updateValues[] = $_GET['isOpened'];
                    }

                    $updateValues[] = $groupID;
                    $updateValues[] = $userID;

                    $stmt = $pdo->prepare("UPDATE usergroup SET " . implode(", ", $updateFields) . " WHERE groupID = ? AND userID = ?");
                    $stmt->execute($updateValues);

                    if ($stmt->rowCount() > 0) {
                        $response = ['message' => 'User-group record updated successfully'];
                        echo json_encode($response);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "User-group record not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Missing or invalid data in the request"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove || TRUE once you've implemented authentication and authorization
                // Handle the DELETE request for deleting a user-friend record
                $GroupID = $_GET['GroupID'];
                $UserID = $_GET['UserID'];

                // Check if the required parameters are present
                if (isset($UserID) && isset($GroupID)) {
                    $stmt = $pdo->prepare("DELETE FROM usergroups WHERE GroupID = ? AND UserID = ?");
                    $stmt->execute([$GroupID, $UserID]);

                    if ($stmt->rowCount() > 0) {
                        $response = ['message' => 'User-group record deleted successfully'];
                        echo json_encode($response);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "User-friend record not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Missing or invalid parameters in the request"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'userfriends':
        // Endpoint for retrieving all user-friend mappings
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if UserID filter is provided
            if (isset($_GET['UserID'])) {
                $filters[] = "UserID = ?";
            }
            // Check if FriendID filter is provided
            if (isset($_GET['FriendID'])) {
                $filters[] = "FriendID = ?";
            }
            $result = getWithFilters($pdo, $filters, "userfriends");
            echo json_encode($result);
        }
        // Endpoint for creating a new user-friend mapping
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new user-friend mapping
                $data = json_decode(file_get_contents('php://input'), true);
                $userId = $data['userId'];
                $friendId = $data['friendId'];

                $stmt = $pdo->prepare("INSERT INTO userfriends (UserID, FriendID) VALUES (?, ?)");
                $stmt->execute([$userId, $friendId]);

                $response = [
                    'message' => 'User-friend mapping created successfully'
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove || TRUE once you've implemented authentication and authorization
                // Handle the PUT request for updating an existing user-friend record
                $userid = $_GET['userid'];
                $friendsid = $_GET['friendsid'];

                // Check if the required data is present
                if (isset($_GET['is_accepted'])) {
                    $is_accepted = $_GET['is_accepted'];

                    $stmt = $pdo->prepare("UPDATE userfriends SET is_accepted = ? WHERE userid = ? AND friendsid = ?");
                    $stmt->execute([$is_accepted, $userid, $friendsid]);

                    if ($stmt->rowCount() > 0) {
                        $response = ['message' => 'User-friend record updated successfully'];
                        echo json_encode($response);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "User-friend record not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Missing or invalid data in the request"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove || TRUE once you've implemented authentication and authorization
                // Handle the DELETE request for deleting a user-friend record
                $userid = $_GET['userid'];
                $friendsid = $_GET['friendsid'];

                // Check if the required parameters are present
                if (isset($userid) && isset($friendsid)) {
                    $stmt = $pdo->prepare("DELETE FROM userfriends WHERE userid = ? AND friendsid = ?");
                    $stmt->execute([$userid, $friendsid]);

                    if ($stmt->rowCount() > 0) {
                        $response = ['message' => 'User-friend record deleted successfully'];
                        echo json_encode($response);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "User-friend record not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Missing or invalid parameters in the request"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;

    case 'groupmessages':
        // Endpoint for retrieving all group messages
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if MessageID filter is provided
            if (isset($_GET['MessageID'])) {
                $filters[] = "MessageID = ?";
            }
            // Check if GroupID filter is provided
            if (isset($_GET['GroupID'])) {
                $filters[] = "GroupID = ?";
            }
            $result = getWithFilters($pdo, $filters, "groupmessages");
            echo json_encode($result);
        }
        // Endpoint for creating a new group message
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new group message
                $data = json_decode(file_get_contents('php://input'), true);
                $userId = $data['userId'];
                $groupId = $data['groupId'];
                $messageContent = $data['messageContent'];
                $messageDate = $data['messageDate'];

                $stmt = $pdo->prepare("INSERT INTO groupmessages (UserID, GroupID, MessageContent, MessageDate) VALUES (?, ?, ?, ?)");
                $stmt->execute([$userId, $groupId, $messageContent, $messageDate]);
                $insertedId = $pdo->lastInsertId();

                $response = [
                    'message' => 'Group message created successfully',
                    'messageId' => $insertedId
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove || TRUE once you've implemented authentication and authorization
                // Handle the PUT request for updating an existing group message
                $messageID = $_GET['messageID'];

                // Check if the required data is present
                if (isset($_GET['body']) || isset($_GET['senderID']) || isset($_GET['groupID']) || isset($_GET['sentTime'])) {
                    $updateFields = [];
                    $updateValues = [];

                    if (isset($_GET['body'])) {
                        $updateFields[] = "body = ?";
                        $updateValues[] = $_GET['body'];
                    }

                    if (isset($_GET['senderID'])) {
                        $updateFields[] = "senderID = ?";
                        $updateValues[] = $_GET['senderID'];
                    }

                    if (isset($_GET['groupID'])) {
                        $updateFields[] = "groupID = ?";
                        $updateValues[] = $_GET['groupID'];
                    }

                    if (isset($_GET['sentTime'])) {
                        $updateFields[] = "sentTime = ?";
                        $updateValues[] = $_GET['sentTime'];
                    }

                    $updateValues[] = $messageID;

                    $stmt = $pdo->prepare("UPDATE groupmessages SET " . implode(", ", $updateFields) . " WHERE messageID = ?");
                    $stmt->execute($updateValues);

                    if ($stmt->rowCount() > 0) {
                        $response = ['message' => 'Group message updated successfully'];
                        echo json_encode($response);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "Group message not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Missing or invalid data in the request"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'groups':
        // Endpoint for retrieving all groups
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if GroupID filter is provided
            if (isset($_GET['GroupID'])) {
                $filters[] = "GroupID = ?";
            }
            // Check if GroupName filter is provided
            if (isset($_GET['GroupName'])) {
                $filters[] = "GroupName = ?";
            }
            $result = getWithFilters($pdo, $filters, "groups");
            echo json_encode($result);
        }
        // Endpoint for creating a new group
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new group
                $data = json_decode(file_get_contents('php://input'), true);
                $groupName = $data['groupName'];
                $groupDescription = $data['groupDescription'];

                $stmt = $pdo->prepare("INSERT INTO groups (GroupName, GroupDescription) VALUES (?, ?)");
                $stmt->execute([$groupName, $groupDescription]);
                $insertedId = $pdo->lastInsertId();

                $response = [
                    'message' => 'Group created successfully',
                    'groupId' => $insertedId
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove || TRUE once you've implemented authentication and authorization
                // Handle the PUT request for updating an existing group
                $groupID = $_GET['groupID'];

                // Check if the required data is present
                if (isset($_GET['groupName']) || isset($_GET['lastSender'])) {
                    $updateFields = [];
                    $updateValues = [];

                    if (isset($_GET['groupName'])) {
                        $updateFields[] = "groupName = ?";
                        $updateValues[] = $_GET['groupName'];
                    }

                    if (isset($_GET['lastSender'])) {
                        $updateFields[] = "lastSender = ?";
                        $updateValues[] = $_GET['lastSender'];
                    }

                    $updateValues[] = $groupID;

                    $stmt = $pdo->prepare("UPDATE groups SET " . implode(", ", $updateFields) . " WHERE groupID = ?");
                    $stmt->execute($updateValues);

                    if ($stmt->rowCount() > 0) {
                        $response = ['message' => 'Group updated successfully'];
                        echo json_encode($response);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "Group not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Missing or invalid data in the request"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'messages':
        // Endpoint for retrieving all messages
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if MessageID filter is provided
            if (isset($_GET['MessageID'])) {
                $filters[] = "MessageID = ?";
            }
            // Check if SenderID filter is provided
            if (isset($_GET['SenderID'])) {
                $filters[] = "SenderID = ?";
            }
            // Check if RecipientID filter is provided
            if (isset($_GET['RecipientID'])) {
                $filters[] = "RecipientID = ?";
            }
            $result = getWithFilters($pdo, $filters, "messages");
            echo json_encode($result);
        }
        // Endpoint for creating a new message
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new message
                $data = json_decode(file_get_contents('php://input'), true);
                $senderId = $data['senderId'];
                $recipientId = $data['recipientId'];
                $messageContent = $data['messageContent'];
                $messageDate = $data['messageDate'];

                $stmt = $pdo->prepare("INSERT INTO messages (SenderID, RecipientID, MessageContent, MessageDate) VALUES (?, ?, ?, ?)");
                $stmt->execute([$senderId, $recipientId, $messageContent, $messageDate]);
                $insertedId = $pdo->lastInsertId();

                $response = [
                    'message' => 'Message created successfully',
                    'messageId' => $insertedId
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove || TRUE once you've implemented authentication and authorization
                // Handle the PUT request for updating an existing message
                $messageID = $_GET['messageID'];
                $body = $_GET['body'];


                $stmt = $pdo->prepare("UPDATE messages SET body = ?WHERE messageID = ?");
                $stmt->execute([$body,$messageID]);

                if ($stmt->rowCount() > 0) {
                    $response = ['message' => 'Message updated successfully'];
                    echo json_encode($response);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Message not found"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;
    case 'chats':
        // Endpoint for retrieving all chats
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            // Check if chatID filter is provided
            if (isset($_GET['chatID'])) {
                $filters[] = "chatID = ?";
            }
            // Check if userID1 filter is provided
            if (isset($_GET['userID1'])) {
                $filters[] = "userID1 = ?";
            }
            // Check if userID2 filter is provided
            if (isset($_GET['userID2'])) {
                $filters[] = "userID2 = ?";
            }
            $result = getWithFilters($pdo, $filters, "chats");
            echo json_encode($result);
        }
        // Endpoint for creating a new chat
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($is_authenticated && $is_authorized) {
                // Handle the POST request for creating a new chat
                $data = json_decode(file_get_contents('php://input'), true);
                $userID1 = $data['userID1'];
                $userID2 = $data['userID2'];
                $lastSender = $data['lastSender'];
                $isOpened = $data['isOpened'];
                $lastEvent = $data['lastEvent'];

                $stmt = $pdo->prepare("INSERT INTO chats (userID1, userID2, lastSender, isOpened, lastEvent) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$userID1, $userID2, $lastSender, $isOpened, $lastEvent]);
                $insertedId = $pdo->lastInsertId();

                $response = [
                    'message' => 'Chat created successfully',
                    'chatID' => $insertedId
                ];
                echo json_encode($response);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["error" => "Access denied"]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if ($is_authenticated && $is_authorized || TRUE) { // Remove or TRUE once you've implemented authentication and authorization
                // Handle the PUT request for updating an existing chat
                $chatID = $_GET['chatID'];
                $lastSender = $_GET['lastSender'];
                $isOpened = $_GET['isOpened'];
                $stmt = $pdo->prepare("UPDATE chats SET lastSender = ?, isOpened = ? WHERE chatID = ?");
                $stmt->execute([$lastSender, $isOpened, $chatID]);

                if ($stmt->rowCount() > 0) {
                    $response = ['message' => 'Chat updated successfully'];
                    echo json_encode($response);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Chat not found"]);
                }
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Access denied"]);
            }
        }
        break;

//useables
    case 'example':

        // Endpoint for retrieving all chats
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            $result = getWithFilters($pdo, $filters, "example");
            echo json_encode($result);
        }
        break;
    case 'employees':

        // Endpoint for retrieving all chats
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            $result = getWithFilters($pdo, $filters, "employees");
            echo json_encode($result);
        }
        break;

    case 'weeklydata':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filters = [];
            $result = getWithFilters($pdo, $filters, "weeklydata");
            echo json_encode($result);
        }
        break;








    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"]);
        echo " API ENDPOINTS 
                /users
                /projects
                /tasks
                /usertasks
                /userprojects
                /taskprojects
                /usergroups
                /userfriends
                /groupmessages
                /groups
                /messages
                /chats";
        break;



}

// Define the authenticate function
function authenticate() {
    $api_key = $_SERVER['HTTP_X_API_KEY'] ?? null;
    $valid_api_keys = ['abc123', 'def456']; // Replace with your valid API keys
    return in_array($api_key, $valid_api_keys);
}


function authorize($endpoint, $method) {
    $authorized_endpoints = [
        'users' => ['POST'],
        'userfriends'=> ['POST','PUT','DELETE'],
        'messages' => ['POST'],
        'usergroups'=>['POST','DELETE'],
        'groups'=>['POST'],
        'groupmessages' => ['POST','PUT']
    ];

    if (!isset($authorized_endpoints[$endpoint])) {
        return false;
    }

    return in_array($method, $authorized_endpoints[$endpoint]);
}
