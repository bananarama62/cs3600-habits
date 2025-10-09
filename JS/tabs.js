function openTab(evt, tabName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
} 

function addHabit(tabName){
  var content;
  content = document.getElementById(tabName);
  var new_id = 0;
  const prefix = tabName.slice(0,tabName.indexOf("-"));
  console.log(prefix);



  if (content.children.length > 0){
    const id_numbers = [];
    // Gets the id numbers of all habits in the list
    for(var i=0; i< content.children.length; i++){
      console.log(content.children[i]);
      var text = content.children[i].firstElementChild.firstElementChild.id;
      console.log("text: " + text);
      var cut = text.indexOf("-");
      if (cut >= 0){
        id_numbers.push(Number(text.slice(cut+1)));
      }
    }

    id_numbers.sort();
    console.log(id_numbers);
    new_id = id_numbers[id_numbers.length-1]+1; // Defaults to just incrementing last id by 1
    console.log(new_id);
    // Searches for gaps in id numbers to fill
    if(id_numbers[0] > 0){
      new_id = 0;
    } else {
      for(var i=0; i < id_numbers.length-1;++i){
        if(id_numbers[i]+1 < id_numbers[i+1]){
          new_id = id_numbers[i]+1;
          break;
        }
      }
    }
  }
  
  // Creates the HTML element that houses the habit
  // Text element will have to be changed to some sort of input when backend is done
  const label = document.createElement("label");
  label.classList.add("habit");
  const input = document.createElement("input");
  input.type = "checkbox";
  input.classList.add("toggle-habit");
  input.id = input.name = prefix + "-" + new_id;
  const placeholder = document.createTextNode("This habit is to do...");

  label.appendChild(input);
  label.appendChild(placeholder);

  // Creates the HTML elements that house the buttons for modifying and deleting elements
  const button_div = document.createElement("div");
  button_div.classList.add("habit-modification-buttons");
  button_div.classList.add("flex");
  const modify_button = document.createElement("button");
  modify_button.innerText="Modify";

  const delete_button = document.createElement("button");
  delete_button.innerText="Delete";
  delete_button.setAttribute("onclick","removeHabit('"+input.id+"')");
  
  button_div.appendChild(modify_button);
  button_div.appendChild(delete_button);

  // Wrapper div
  const wrapper_div = document.createElement("div");
  wrapper_div.classList.add("flex");
  
  wrapper_div.appendChild(label);
  wrapper_div.appendChild(button_div);

  content.appendChild(wrapper_div);
}

function removeHabit(habitId){
  input = document.getElementById(habitId).parentElement.parentElement.remove();
}
