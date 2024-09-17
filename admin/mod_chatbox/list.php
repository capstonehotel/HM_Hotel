<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messenger</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <style>
    body {
      display: flex;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .chat-container {
      display: flex;
      flex-direction: row;
      width: 100%;
      height: 100%;
    }

    /* Sidebar */
    .sidebar {
      background-color: #343a40;
      width: 300px;
      padding: 20px;
      overflow-y: auto;
      color: white;
    }

    .sidebar .user {
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 10px;
      background-color: #495057;
    }

    .sidebar .user:hover {
      background-color: #6c757d;
      cursor: pointer;
    }

    /* Chat Area */
    .chat-area {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .chat-header {
      padding: 15px;
      background-color: #007bff;
      color: white;
      text-align: center;
      font-size: 18px;
    }

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
      max-width: 60%;
      padding: 10px;
      border-radius: 10px;
      background-color: #007bff;
      color: white;
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
</head>
<body>

  <div class="chat-container">
    <!-- Sidebar with contacts -->
    <div class="sidebar">
      <h4>Contacts</h4>
      <div class="user">John Doe</div>
      <div class="user">Jane Smith</div>
      <div class="user">David Johnson</div>
    </div>

    <!-- Chat area -->
    <div class="chat-area">
      <div class="chat-header">
        Chat with <span id="chatUser">John Doe</span>
      </div>
      <div class="chat-messages" id="chatMessages">
        <!-- Messages will be dynamically inserted here -->
      </div>

      <div class="message-form">
        <input type="text" id="messageInput" placeholder="Type a message..." />
        <button class="btn btn-primary" id="sendButton"><i class="fa fa-paper-plane"></i></button>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery for AJAX -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      let currentUser = 'John Doe';

      // Add sample messages
      const messages = [
        { from: 'John Doe', text: 'Hello there!' },
        { from: 'You', text: 'Hi! How are you?' },
      ];

      const chatMessages = $('#chatMessages');

      // Function to display messages
      function displayMessages() {
        chatMessages.html('');
        messages.forEach(msg => {
          const messageClass = msg.from === 'You' ? 'sent' : '';
          const messageHTML = `
            <div class="message ${messageClass}">
              <div class="content">${msg.text}</div>
            </div>
          `;
          chatMessages.append(messageHTML);
        });
        chatMessages.scrollTop(chatMessages[0].scrollHeight); // Scroll to the bottom
      }

      displayMessages();

      // Send button click event
      $('#sendButton').click(function() {
        const messageText = $('#messageInput').val();
        if (messageText.trim() !== '') {
          messages.push({ from: 'You', text: messageText });
          $('#messageInput').val('');
          displayMessages();

          // Optionally, here you can add AJAX to send the message to the server
        }
      });
    });
  </script>
</body>
</html>
