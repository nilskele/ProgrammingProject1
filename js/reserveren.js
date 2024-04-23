function addEvent() {
    var eventInput = document.getElementById("eventInput");
    var eventName = eventInput.value.trim();
    
    if (eventName !== "") {
      var eventList = document.getElementById("eventList");
      var listItem = document.createElement("li");
      listItem.innerHTML = '<span>' + eventName + '</span> <button onclick="editEvent(this)">Edit</button> <button onclick="deleteEvent(this)">Delete</button>';
      eventList.appendChild(listItem);
      
      eventInput.value = "";
    } else {
      alert("Please enter an event name.");
    }
  }
  
  function editEvent(button) {
    var eventName = button.previousElementSibling.textContent;
    var newEventName = prompt("Edit event:", eventName);
    
    if (newEventName !== null && newEventName.trim() !== "") {
      button.previousElementSibling.textContent = newEventName.trim();
    }
  }
  
  function deleteEvent(button) {
    var listItem = button.parentElement;
    listItem.remove();
  }