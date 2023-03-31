import logo from './logo.svg';
import './App.css';


let userId;
const loginPage = () =>{
  return (
    <div>
      
      <h1>Gautami and Elizabeth's Nutrition App</h1>
      <br></br>
      <br></br>
      <br></br>
      <br></br>
   
      <input id = "newUsername" type = "text" placeholder = "new username" ></input>
      <input id = "newPass" type = "text" placeholder = "new password" ></input>
      <input id = "private" type = "checkbox"></input>
      <label htmlFor='private'>Private?</label>
      <button id = "signUp" onClick = {addUser}>Sign Up!</button>


      <br></br>
      <br></br>
      <br></br>
     
      <input id = "username" type = "text" placeholder = "username" ></input>
      <input id = "pass" type = "text" placeholder = "password" ></input>
      <button id = "login" onClick = {login}>log in</button>

      <br></br>
      <br></br>
      <button id = "guest" onClick = {goToExplorePage}>Login As Guest</button>
      <br></br>
      <br></br>
      <div id = "buttons">

      </div>
      <br></br>
      <br></br>
      <br></br>
      <br></br>
      <button id = "logout" onClick = {logout}>Logout</button>
      
    
    <p id = "loginResponse"></p>
  </div> 
  )
 }
 



function App() { //compiles app and exports to index.js
  console.log("in app function");
  if(currentPage == "login"){
  return (
    loginPage()
  );
  }
  if(currentPage == "explorePage"){
    return (
      displayExplorePage()
    );
  }
}

async function addUser(event){ //adds user to data table
  
      let thisUsername = String(document.getElementById("newUsername").value);
      let thisPass = String(document.getElementById("newPass").value);
      let isPrivate = String(document.getElementById("private").checked);
      console.log("made it into javascript function");
      let data = {"username" : thisUsername, "pass" : thisPass, "private": isPrivate}

  fetch("http://ec2-54-153-91-49.us-west-1.compute.amazonaws.com/~egirling/nutritionapp/register.php", {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {'Access-Control-Request-Headers':"*"}
  })
      .then(response => response.json())
      .then(data => document.getElementById("loginResponse").innerHTML = (data.success ? "You've registered!" : `You were not registered ${data.message}`))
      .catch(err => console.error(err));
}




async function login(event){ //checks password 
  let thisUsername = String(document.getElementById("username").value);
  let thisPass = String(document.getElementById("pass").value);

  let data = {"username" : thisUsername, "pass" : thisPass};

  fetch("http://ec2-54-153-91-49.us-west-1.compute.amazonaws.com/~egirling/nutritionapp/login.php", {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {'Access-Control-Request-Headers':"*"}
  })
      .then(response => response.json())
      .then(data => {if(data.success){ //creates buttons only when user successfully logs in
        userId = data["userId"];
        console.log(userId);
        console.log(data.sessionid);
        console.log("in success second then")
        let calculatorButton = document.createElement("button");
        let calcName = document.createTextNode("Go To Calculator Page");
        calculatorButton.appendChild(calcName);
        calculatorButton.setAttribute("id", "goToCalculator");
       

        let myStats = document.createElement("button");
        let statsName = document.createTextNode("Got To My Stats");
        myStats.appendChild(statsName);
        myStats.setAttribute("id", "myStats");

        let explore = document.createElement("button");
        let exploreName = document.createTextNode("Go To Explore Page")
        explore.appendChild(exploreName);
        explore.setAttribute("id", "explore");

        let postButton = document.createElement("button");
        let postName = document.createTextNode("Make A Post!");
        postButton.appendChild(postName);
        postButton.setAttribute("id", "goToPost");

        document.getElementById("buttons").appendChild(calculatorButton);
        document.getElementById("buttons").appendChild(myStats);
        document.getElementById("buttons").appendChild(explore);
        document.getElementById("buttons").appendChild(postButton);

        document.getElementById("explore").addEventListener("click", displayExplorePage);
        document.getElementById("goToCalculator").addEventListener("click", displayCalculatorPage);
        document.getElementById("myStats").addEventListener("click", displayMyStatsPage);
        document.getElementById("goToPost").addEventListener("click", displayPostPage);

      }
    })
      .then(console.log("after our shit"))
      .catch(err => console.error(err));
}

function goToExplorePage(){ //sends user to explore page
 
  currentPage = "explorePage";
  App();
}

const displayExplorePage = () =>{ //sends user to display page
  
  window.location.href='http://ec2-54-153-91-49.us-west-1.compute.amazonaws.com:3000/sharePage.html';
  return (
    <div>
    <br></br>
    <p>In explore page</p>
    </div>
  )
}
const displayPostPage = () =>{ //sends user to display Post page
  
  window.location.href='http://ec2-54-153-91-49.us-west-1.compute.amazonaws.com:3000/makePosts.html';
  return (
    <div>
    <br></br>
    <p>In explore page</p>
    </div>
  )
}

const displayCalculatorPage = () =>{ //sends user to calculator page
  
  window.location.href='http://ec2-54-153-91-49.us-west-1.compute.amazonaws.com:3000/calculatorPage.html';
  return (
    <div>
    <br></br>
    <p>In explore page</p>
    </div>
  )
}

const displayMyStatsPage = () =>{ //sends user to display my stats page
  
  window.location.replace('http://ec2-54-153-91-49.us-west-1.compute.amazonaws.com:3000/myStatsPage.html');
  return (
    <div>
    <br></br>
    <p>In explore page</p>
    </div>
  )
}
function logout(){
  userId = "";
  window.location.reload();
}


export default App;
