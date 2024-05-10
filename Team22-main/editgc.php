<?php
session_start();
// $_SESSION['userID'] =1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="chatstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>    
    <div class="min-h-screen flex">
   
    <aside class="w-1/4 pt-6 shadow-lg flex flex-col justify-between transition duration-500 ease-in-out transform" id="sidebar">            
                <div>
                    <form action="chats.php" class="sidebar-form">
                        <button type="submit" class="sidebar-btn"><div class="sidebar-cell"><i class="bi bi-chat-right" style="padding-right:5px"></i><p style="padding-right: 5px;">Chats</p><div id="chats-notification" class="notification"></div></div></button>
                    </form>
                    <form action="groupchats.php" class="sidebar-form">
                        <button type="submit" class="sidebar-btn-clicked"><div class="sidebar-cell"><i class="bi bi-people-fill" style="padding-right:5px"></i><p style="padding-right: 5px;">Group Chats</p><div id="groupchats-notification" class="notification"></div></div></button>
                    </form>
                    <form action="friends.php" class="sidebar-form">
                        <button type="submit" class="sidebar-btn"><div class="sidebar-cell"><i class="bi bi-person-check" style="padding-right:5px"></i><p style="padding-right: 5px;">Friends</p><div id="friends-notification" class="notification"></div></div></button>
                    </form>

                </div>
            
                        <div class="p-6 transition duration-500 ease-in-out transform">
                            <p class="mb-4 text-m" style="color:gray;text-align:center">User Logged In</p>
                            <form class="sidebar-form">
                                <button type="submit" class="logout-btn">Log Out</button>
                            </form>
                        </div>
        </aside>

        <main class="flex-1 p-6" id = "main">


                <div class="card">
                    <div style="display:flex;align-items:center">
                        <div style="width:5%;align-items:center;padding-bottom:12px">
                            <span class="material-symbols-outlined" id="back_symbol" style="font-size: 25px; color:white;" onclick="backButton()">arrow_back</span>
                        </div>
                        <div class="card-header" id="new-group-header" style="width:80%">Edit Group</div>
                        <div style="text-align:right; width:15%">
                            <!-- <button class="new-button" onclick = "createGroupChat()"><i class="bi bi-plus-lg"></i> Create Group</button> -->
                        </div>
                    </div>
                    


                    <div class="search-container">
                        <div class="search-container">
                            <input class="search-bar" id="title-search-bar" placeholder="Group Name" required></input>
                        </div>
                        <div class="search-container" style="display:flex">
                            <div style="padding-right: 10px">
                                <input class="search-bar" id="search-bar" placeholder="Add People"></input>
                            </div>
                            
                            <button class="filter-button" id="addFriendsButtonGC" type="button" onclick=addName()>Add Name</button>
                        </div>
                        
                        
                        <div class="results-box"></div>
                    </div>

                    

                </div>

                <div class="card">
                    <div class="card-header" id="members-header">Members</div>
                    <input class="search-bar" id="members-search-bar" placeholder="Add People"></input>
                    <ul id="groupList">
                    </ul>
                </div>
            </div>

        </main>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- <script src = "notification.js"></script> -->
<script>
    //inserting friends from database:
    const urlParams = new URLSearchParams(window.location.search)
    const groupID = urlParams.get("groupID")

    console.log("group id is: "+groupID);

    const inputtest = document.getElementById("search-bar").value;
    const listNames = document.getElementById("groupList");
    //const listRequests = document.getElementById("requestsList");

    const userID = <?php echo $_SESSION['userID'] ?>;
    console.log("User id is:"+userID);

    const currentUsername = '<?php echo $_SESSION['Username'] ?>';
    console.log("Username is: "+ currentUsername);

    
    fetch('http://localhost/Team22/API/usergroups?GroupID='+groupID)
        .then(response => {
            //console.log('Response:', response);
            return response.text(); // Get the response text
        })
        .then(text => {
           //console.log('Response Text:', text); // Log the response text
            // Attempt to parse the response text as JSON
            const data = JSON.parse(text);
            //console.log('Data:', data);
            //content="";

            fetch('http://localhost/Team22/API/users')
                .then(response => {
                    //console.log('Response:', response);
                    return response.text(); // Get the response text
                })
                .then(text => {
                    //console.log('Response Text:', text); // Log the response text
                    // Attempt to parse the response text as JSON
                    const data2 = JSON.parse(text);
                    console.log('Data:', data2);
                    content="";
                    userNames=[];
                    data2.forEach(item2=>{
                        data.forEach(item=>{
                            if (item.UserID==item2.UserID){
                                content += "<li>"+item2.Username+"<button type='button' onclick='removeFriend(this,true)'>remove</button></li>";
                                userNames.push(item2.Username);
                                        
                            }
                        })
                        
                        
                    });
                    listNames.innerHTML = content;




                })
                .catch(error => {
                    console.error('Error:', error);
                });
                    
                    

            })
            .catch(error => {
                console.error('Error:', error);
            });
        


    const inputBox = document.getElementById("search-bar");
    const resultsBox = document.querySelector(".results-box")


    function selectInput(x) {
            //selectInput is called by clicking on a name displayed in the div results-box
            //the name is then displayed in the input box with id 'members-entry'
            inputBox.value = x.innerHTML
            resultsBox.innerHTML = ""
        }

    document.getElementById("search-bar").addEventListener("keyup", function() {
        //When the input box 'members-entry' has had a key entered in it
        const input = document.getElementById("search-bar").value

        //const cardHeader = document.getElementById("friends-header");
        
        //searchFilter(document.getElementById("friendsList"));

            if (input.length==0){
                console.log("NOTHING TYPED");
                resultsBox.innerHTML = ""
            }else{
                fetch('http://localhost/Team22/API/users')
                        .then(response => {
                            console.log('Response:', response);
                            return response.text(); // Get the response text
                        })
                        .then(text => {
                            console.log('Response Text:', text); // Log the response text
                            // Attempt to parse the response text as JSON
                            const data = JSON.parse(text);
                            console.log('Data:', data);
                            content="";
                            data.forEach(item=>{
                                if (item.Username.toLowerCase().includes(input.toLowerCase())){
                                    content += "<li onclick=selectInput(this)>"+item.Username+"</li>";
                                }
                            });
                            content = "<ul>"+content+"</ul>";
                            $(".results-box").html(content);

                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
            }
        


    });

    document.getElementById("members-search-bar").addEventListener("keyup", function() {
        //When the input box 'members-entry' has had a key entered in it
        const input = document.getElementById("search-bar").value

        const cardHeader = document.getElementById("friends-header");
        
        searchFilter(document.getElementById("groupList"));
    });

    function searchFilter(listnames){
        //FriendsHeader is to differntiate between headers
        //true is friends header, false will be requests header
        console.log("Search filter func called");
        const searchVal = document.getElementById("members-search-bar").value 
        
        //const listnames = document.getElementById("friendsList")
        const listItems = listnames.getElementsByTagName("li")
        // Checks for name entered is already in the team
        const membersList = []

        for (let i = 0; i < listItems.length; i++) {
            //for loop goes through the current team members

            //Line below ensures that the string only contains the name
            let thename = ""

            thename = listItems[i].textContent.replace("remove", "")

            console.log("INCLUDES: "+thename.toUpperCase().includes(searchVal.toUpperCase()));
            if (thename.toUpperCase().includes(searchVal.toUpperCase())){
                listItems[i].style.display = "";
                console.log(thename+" is shown");
            }else{
                listItems[i].style.display = "none";
                console.log(thename+" is hidden");
            }
        }
    }



    function addName() {
            //buttonfunc is a function that adds the name entered in input box 'members-entry' and displays it in 'team-members- as a list
            const addname = document.getElementById("search-bar").value
            const listnames = document.getElementById("groupList")
            const listItems = listnames.getElementsByTagName("li")

            // Checks for name entered is already in the team
            const membersList = []
            let duplicate = false

            for (let i = 0; i < listItems.length; i++) {
                //for loop goes through the current team members

                //Line below ensures that the string only contains the name
                const thename = listItems[i].textContent.replace("remove", "")


                if (thename === addname) {
                    //if name entered is already a team member then duplicate is set to true
                    duplicate = true
                    
                } else {
                    //else adds name to list of team members
                    membersList.push(listItems[i].textContent.replace("remove", ""))

                }
            }
            if (addname==currentUsername){
                alert("Cannot add yourself");
            }else if (duplicate==true){
                alert("name already added");
            }else{
                //fetch('http://localhost/API/users?Username='+addname)
                fetch('http://localhost/Team22/API/users?Username='+addname)
                        .then(response => {
                            console.log('Response:', response);
                            return response.text(); // Get the response text
                        })
                        .then(text => {
                            console.log('Response Text:', text); // Log the response text
                            // Attempt to parse the response text as JSON
                            data = JSON.parse(text);
                            //console.log('Data:', data);
                            console.log("data length:"+data.length);
                            if (data.length==0){
                                alert("name entered must be in database");
                            }else{
                                console.log("Friend username is: "+data[0]['Username']);
                                console.log("Friend userID is: "+data[0]['UserID']);

                                //POST
                                //---------------------------------------------------------------------------
                                const endpoint = 'http://localhost/Team22/API/usergroups';

                                const requestData = {
                                    UserID: data[0]['UserID'].toString(),
                                    GroupID: groupID
                                };

                                // Convert the request data to a query string
                                const queryParams = new URLSearchParams(requestData).toString();

                                // Append the query parameters to the endpoint URL
                                const requestUrl = `${endpoint}?${queryParams}`;

                                // Define the request options
                                const requestOptions = {
                                    method: 'POST',
                                    headers: {
                                        'X-API-KEY': 'abc123' // Replace with a valid API key
                                    }
                                };

                                // Send the request
                                fetch(requestUrl, requestOptions)
                                    .then(response => {
                                        if (response.ok) {
                                            return response.json();
                                        } else {
                                            throw new Error('Request failed with status ' + response.status);
                                        }
                                    })
                                    .then(data1 => {
                                        console.log('Response data:', data1);
                                        alert("They have been added to the group");
                                        content = "<li>"+data[0]['Username']+"<button type='button' onclick='removeFriend(this)'>remove</button></li>";
                                        listNames.innerHTML += content;
                                        // Handle the response data as needed
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        // Handle the error as needed
                                    });
                            
                            }
                            
                        })
                    
                        //---------------------------------------------------------------

                        .catch(error => {
                            console.error('Error:', error);
                        });

                        //
                    


            }

            

    }

        function removeItem(element) {
            //removeItem is called when the 'remove' button is pressed to remove a name from a team
            const urlParams = new URLSearchParams(window.location.search)

            console.log(element);
            
            let listItem = element.parentNode

            listItem = element.parentNode

            // Get the parent <ul> element
            const list = listItem.parentNode

            // Remove the <li> element from the <ul> element
            list.removeChild(listItem)

        }
    

        function removeFriend(element){
            console.log("REMOVE FRIEND FUNC ---------------------");
            const urlParams = new URLSearchParams(window.location.search)

            console.log(element);

            let listItem = element.parentNode

            const text = listItem.textContent.trim()
            console.log(text);

            let name = ""


            name = text.replace("remove", "")



            // let name = text.replace('remove','');
            // console.log("Name is: " + name);

            fetch('http://localhost/Team22/API/users?Username='+name)
                .then(response => {
                    console.log('Response:', response);
                    return response.text(); // Get the response text
                })
                .then(text => {
                    console.log('Response Text:', text); // Log the response text
                    // Attempt to parse the response text as JSON
                    data = JSON.parse(text);
                    //console.log('Data:', data);
                    console.log("Friend username is: "+data[0]['Username']);
                    console.log("Friend userID is: "+data[0]['UserID']);

                    //DELETE--------------------------------------------------------
                    const endpoint = 'http://localhost/Team22/API/usergroups';

                    const requestData = {
                        GroupID: groupID,
                        UserID: data[0]['UserID'].toString()
                    };

                    // Convert the request data to a query string
                    const queryParams = new URLSearchParams(requestData).toString();

                    // Append the query parameters to the endpoint URL
                    const requestUrl = `${endpoint}?${queryParams}`;

                    // Define the request options
                    const requestOptions = {
                        method: 'DELETE',
                        headers: {
                            'X-API-KEY': 'abc123' // Replace with a valid API key
                        }
                    };

                    // Send the request
                    fetch(requestUrl, requestOptions)
                        .then(response => {
                            if (response.ok) {
                                
                                return response.json();
                            } else {
                                throw new Error('Request failed with status ' + response.status);
                            }
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            removeItem(element);
                            // Handle the response data as needed
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Handle the error as needed
                        });

                })
            
                //---------------------------------------------------------------

                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // disableMyFriendsButton();
        // setInterval(() => {
        //     generateRequestsNotification();
        // }, 1000);

</script>
</body>
</html>