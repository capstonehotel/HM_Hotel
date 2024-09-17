<div class="container-fluid">
  <div class="row">
    <!-- Left column: Contacts (Chat List) -->
    <div class="col-md-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Chat List</h6>
        </div>
        <div class="card-body">
          <div class="user">John Doe</div>
          <div class="user">Jane Smith</div>
          <div class="user">David Johnson</div>
        </div>
      </div>
    </div>

    <!-- Right column: Chat Area -->
    <div class="col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3 chat-header">
          Chat with <span id="chatUser">John Doe</span>
        </div>
        <div class="card-body chat-messages" id="chatMessages">
          <!-- Messages will be dynamically inserted here -->
        </div>
        <div class="card-footer message-form">
          <input type="text" id="messageInput" class="form-control" placeholder="Type a message..." />
          <button class="btn btn-primary mt-2" id="sendButton"><i class="fa fa-paper-plane"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Styles -->
<style>
  body {
    height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: Arial, sans-serif;
  }
  .user {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 10px;
    background-color: #495057;
    color: white;
    cursor: pointer;
  }
  .user:hover {
    background-color: #6c757d;
  }
  .chat-messages {
    height: 400px;
    overflow-y: auto;
    background-color: #f8f9fa;
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
</style>

<!-- Scripts -->
<script>
  $(document).ready(function() {
    let currentUser = 'John Doe';

    const messages = [
      { from: 'John Doe', text: 'Hello there!' },
      { from: 'You', text: 'Hi! How are you?' },
    ];

    const chatMessages = $('#chatMessages');

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
      chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }

    displayMessages();

    $('#sendButton').click(function() {
      const messageText = $('#messageInput').val();
      if (messageText.trim() !== '') {
        messages.push({ from: 'You', text: messageText });
        $('#messageInput').val('');
        displayMessages();
      }
    });
  });
</script>
