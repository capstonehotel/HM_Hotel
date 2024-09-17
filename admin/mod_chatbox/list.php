<style>
    .chat-messages {
    flex: 1;
    padding: 20px;
    background-color: #f8f9fa;
    overflow-y: auto;
}

.message {
    display: flex;
    margin-bottom: 15px;
}

.message.sent {
    justify-content: flex-end;
}

.message .content {
    display: inline-block; /* Ensure it only takes up as much space as the text */
    max-width: 60%; /* Set a max width so long messages wrap */
    padding: 10px;
    border-radius: 10px;
    background-color: #007bff;
    color: white;
    word-wrap: break-word; /* Ensure long words are wrapped */
}

.message.sent .content {
    background-color: #495057;
}

.message-form {
    padding: 10px;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
}

.message-form input {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 5px;
}

.message-form button {
    margin-left: 10px;
}

</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        

      <!-- Column 1: Chat List -->
<div class="col-md-4 chat-cont-left">
    <div class="chat-header">
        <span>Chats</span>
    </div>
    <form class="chat-search">
        <div class="input-group">
            <div class="input-group-prepend">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
    <div class="chat-users-list">
        <div class="chat-scroll">
            <a href="javascript:void(0);" class="media">
                <div class="media-img-wrap">
                    <div class="avatar avatar-away">
                        <img src="assets/img/profiles/avatar-03.jpg" alt="User Image" class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body">
                    <div>
                        <div class="user-name">Justin Lee</div>
                        <div class="user-last-chat">Hey, How are you?</div>
                    </div>
                    <div>
                        <div class="last-chat-time block">2 min</div>
                        <div class="badge badge-success badge-pill">15</div>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0);" class="media read-chat active">
                <div class="media-img-wrap">
                    <div class="avatar avatar-online">
                        <img src="assets/img/profiles/avatar-04.jpg" alt="User Image" class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body">
                    <div>
                        <div class="user-name">Joe Edwards</div>
                        <div class="user-last-chat">I'll call you later </div>
                    </div>
                    <div>
                        <div class="last-chat-time block">8:01 PM</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>


              <!-- Column 2: Chat Area -->
<div class="col-md-8">
    <div class="chat-area">
        <div class="chat-header">
            Chat with John Doe
        </div>

        <div class="chat-messages">
            <div class="message">
                <div class="content">
                    Hello, how are you?
                </div>
            </div>
            <div class="message sent">
                <div class="content">
                    I am good, thank you!
                </div>
            </div>
        </div>

        <div class="message-form">
            <input type="text" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>
<script>
    // Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get the necessary elements
    const messageForm = document.querySelector(".message-form");
    const messageInput = messageForm.querySelector("input");
    const messageSendButton = messageForm.querySelector("button");
    const chatMessages = document.querySelector(".chat-messages");

    // Function to add a new message to the chat
    function addMessage(content, isSent) {
        // Create message container
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        if (isSent) {
            messageDiv.classList.add("sent");
        }

        // Create content bubble
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");
        contentDiv.textContent = content;

        // Append content to message container
        messageDiv.appendChild(contentDiv);

        // Append message to chat messages
        chatMessages.appendChild(messageDiv);

        // Scroll to the bottom of the chat
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Send button click event listener
    messageSendButton.addEventListener("click", function() {
        // Get the input text
        const messageText = messageInput.value.trim();

        // Only add the message if the input is not empty
        if (messageText !== "") {
            // Add sent message to the chat
            addMessage(messageText, true);

            // Clear the input field after sending
            messageInput.value = "";
        }
    });

    // Optionally, send message on pressing 'Enter' key
    messageInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            messageSendButton.click();
        }
    });
});

</script>

