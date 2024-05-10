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
                        <div class="card-header" id="new-group-header" style="width:80%">New Group</div>
                        <div style="text-align:right; width:15%">
                            <button class="new-button" onclick = "createGroupChat()"><i class="bi bi-plus-lg"></i> Create Group</button>
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
                    <ul id="groupList">
                    </ul>
                </div>
            </div>

        </main>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src = "notification.js"></script>

<script>
    //inserting friends from database:
    const inputtest = document.getElementById("search-bar").value;
    const listNames = document.getElementById("friendsList");
    const listRequests = document.getElementById("requestsList");

    const userID = <?php echo $_SESSION['userID'] ?>;
    console.log("User id is:"+userID);



    const inputBox = document.getElementById("search-bar");
    const resultsBox = document.querySelector(".results-box")


    function selectInput(x) {
            inputBox.value = x.innerHTML
            resultsBox.innerHTML = ""
        }

    document.getElementById("search-bar").addEventListener("keyup", function() {
        
        const input = document.getElementById("search-bar").value

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


    });

    function addName() {
            
            const addname = document.getElementById("search-bar").value
            const listnames = document.getElementById("groupList")
            const listItems = listnames.getElementsByTagName("li")

            
            const membersList = []
            let duplicate = false

            

                for (let i = 0; i < listItems.length; i++) {
                    

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

                if (duplicate==true){
                    alert("name already added");
                }else{
                    
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
                                // console.log("Friend username is: "+data[0]['Username']);
                                // console.log("Friend userID is: "+data[0]['UserID']);

                                listnames.innerHTML += '<li class="new">'+addname+'<button type="button" onclick="removeItem(this)">remove</button></li>';

                                
                                
                                
                            })
                            //---------------------------------------------------------------
                            .catch(error => {
                                console.error('Error:', error);
                            });

                
                }
            


            

    }

    function createGroupChat(){
        const listnames = document.getElementById("groupList")
        const listItems = listnames.getElementsByTagName("li")

        
        const peopleList = []

        const groupTitle = document.getElementById("title-search-bar").value
        console.log(groupTitle);
        //--------------------------------------
        const endpoint = 'http://localhost/Team22/API/groups';

        const requestData = {
            GroupName: groupTitle
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
            .then(data => {
                console.log('Response data:', data);
                //alert("Request has been sent");
                // Handle the response data as needed

                console.log("post request works");

                //---------------------------------------------------------------------------
                /*fetch('http://localhost/Team22/API/groups?GroupName='+groupTitle)
                    .then(response => {
                        console.log('Response:', response);
                        return response.text(); // Get the response text
                    })
                    .then(text => {
                        console.log('Response Text:', text); // Log the response text
                        // Attempt to parse the response text as JSON
                        const data = JSON.parse(text);
                        console.log('Data:', data);
                        addToUserGroups(data[0]['GroupID']);


                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                    */
                //--------------------------------------------------------------------------
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle the error as needed
            });


        //-----------------------------------------




        

       

    }

    function addToUserGroups(groupID){
        const listnames = document.getElementById("groupList")
        const listItems = listnames.getElementsByTagName("li")

        
        const peopleList = []

        for (let i = 0; i < listItems.length; i++) {

            peopleList.push(listItems[i].textContent.replace("remove", ""));
            console.log(peopleList[i]);

        }

        membersList = []
        fetch('http://localhost/Team22/API/users')
            .then(response => {
                console.log('Response:', response);
                return response.text(); // Get the response text
            })
            .then(text => {
                console.log('Response Text:', text); // Log the response text
                // Attempt to parse the response text as JSON
                data = JSON.parse(text);
                //console.log('Data:', data);
                // console.log("Friend username is: "+data[0]['Username']);
                // console.log("Friend userID is: "+data[0]['UserID']);

                data.forEach(item=>{
                    for (let i = 0; i < peopleList.length; i++) {
                        if (item.Username==peopleList[i]){
                            membersList.push(item);
                        }
                        

                    }
                })

                for (let i = 0; i < membersList.length; i++) {
                    console.log("-------------------------------------------")
                    console.log("For user: "+membersList[i].UserID);
                    console.log("Group id is:"+groupID);
                    
                //---------
                    const endpoint = 'http://localhost/Team22/API/usergroups';

                    const requestData = {
                        userID: membersList[i].UserID,
                        groupID: groupID
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
                        .then(data => {
                            console.log('Response data:', data);
                            
                            // Handle the response data as needed
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Handle the error as needed
                        });




                //--------------------
                    }
                    alert("Group chat is created");
                    window.location.href = 'group_messages.php?groupID=' + groupID;

                
                
                
            })
            //---------------------------------------------------------------
            .catch(error => {
                console.error('Error:', error);
            });
    }




    function removeItem(element) {
        //removeItem is called when the 'remove' button is pressed to remove a name from a team
        const urlParams = new URLSearchParams(window.location.search)

        
        let listItem = element.parentNode
        console.log(listItem);

        listItem = element.parentNode

        // Get the parent <ul> element
        const list = listItem.parentNode

        // Remove the <li> element from the <ul> element
        list.removeChild(listItem)

    }

    function backButton() {
        window.location.href = 'groupchats.php';
    }

</script>
<script>
    const currentUserID = <?php echo $_SESSION['userID'] ?>;
    const currentUser = <?php echo $_SESSION['userID'] ?>;
    console.log("User id is:"+currentUserID);
</script>

</body>
</html>
