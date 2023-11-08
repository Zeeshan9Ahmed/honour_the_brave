@extends('layout.master')
@section('layout.header-bar')

@stop
@section('content')
<div class="contentBody">
	<section class="genSec">
		<div class="genRow chatrowMain">


			<div class="chatList">
				<div class="chatSearchBar relClass">
					<input type="seach" class="chatSearch" id="search" placeholder="Find contacts">
					<img src="{{asset('images/searchChat.png')}}" alt="img" class="searchIcon2">
				</div>

				<ul class="list-unstyled" id="chat_inbox">
					

				</ul>
			</div>

			<div class="chatContent">

			
		<!-- header bar end-->


		<div class="contentBody">
			<div class="chatWrap">
				<a href="#!" class="memToggle xy-center"><i class="fa-solid fa-users"></i></a>
				<div class="chatHeader">
					<a href="#!" class="chatPerson">
						<span class="chatPersonImg">
							<img id="user_image" src="{{asset('images/chatPerson-10.png')}}" alt="img" hidden>
						</span>
						<p class="chatName" id="user_name"></p>
						<input type="hidden" id="receiver_id" value="" />
					</a>
				</div>

				<div class="chatMid" id="chat">

				<div class="chatNull xy-center">
                        <img src="{{asset('images/chat-demo.png')}}" alt="img" class="img-fluid">

                        <p class="desc pt-3">No messages, new messages will appear here</p>
                    </div>
					


		</div>

		<div id="text-input" class="typeBox d-none">
			<textarea class="typeMessage" id="chat_message" placeholder="Start typing here"></textarea>
			<a href="#!" class="sendBtn2 xy-center" id="send_message">
				<img src="{{asset('images/paper-plane.png')}}" alt="img">
			</a>
		</div>
</div>
</div>
</div>
</div>
</section>
</div>
@endsection

@section('additional_scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script src="https://cdn.socket.io/4.4.1/socket.io.min.js" integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous"></script>

<script>
	$(document).ready(function() {

		var users = <?php echo json_encode($chats); ?>;
		base_path = "{{url('/public/')}}";
		local_image = "{{asset('images/user.png')}}";

		console.log(users)
		const generateChatInbox = (inboxes) => {
			if (inboxes.length == 0) return `<p class="noChat xy-center">User Not Found</p>`;
			return inboxes.map(inbox => {
				image_url = `${inbox.avatar?base_path+inbox.avatar:local_image}`;
				return `<li id="users" data-id="${inbox.id}" data-image="${image_url}" data-name="${inbox.full_name}">
				<a href="#!" class="chatPerson">
				<span class="chatPersonImg">
				<img src="${image_url}" alt="img">
				</span>
				<span class="userName">
					<p class="chatName">${inbox.full_name}</p>
					<p class="desc">${inbox.chat_message}</p>
					<p class="msgTime">${inbox.created_at}</p>
				</span>
				</a>
				</li>`;
			}).join("");
		}
		$("#chat_inbox").html(generateChatInbox(users));
		const filterItems = (needle, heystack) => {
			let query = needle.toLowerCase();
			return heystack.filter(item => item.full_name?.toLowerCase().indexOf(query) >= 0);
		}

		$('#search').keyup(function(e) {
			search = $('#search').val()
			inboxes = filterItems(search, users);
			$("#chat_inbox").html(generateChatInbox(inboxes));

			if (e.keyCode == 8) {
				// $('#inbox_html').html(generateChatInbox(filterItems(search, users)))
			}
		})
		const socket = io.connect("https://server1.appsstaging.com:3076");
		socket.on("connect", () => {
			console.log(socket.connected); // true
		});

		socket.on("error", (error_messages) => {
			not('Something went wrong', 'error');
		});



		socket.on("disconnect", () => {
			console.log(socket.connected); // false
		});

		user_id = "{{auth()->id()}}"

		function genereateChat(messages) {

			chat = messages.map(message => {
				// console.log(message.avatar)
				// return;
				image_url = `${message.avatar?base_path+message.avatar:local_image}`;
				return `<div class="chatItem ${message.chat_sender_id == user_id?"rightMsg":"leftMsg"}">
							<div class="chatHead d-flex pb-3">
								<div class="info1">
								    <p class="timeText">${formatAMPM(message.created_at)}</p>
									<p class="name">${message?.full_name??"---"}</p>
								</div>
								<img src="${image_url}" alt="img">
							</div>
							<p class="textMessage">
								${message.chat_message}
							</p>
						</div>`;
			}).join("");
			return chat;
		}


		$(document).on('click', '#users', function() {
			user_data = $(this)
			sender_id = user_id;
			reciever_id = user_data.attr('data-id');
			user_image = user_data.attr('data-image');
			user_name = user_data.attr('data-name');

			$("#user_image").removeAttr('hidden')

			$("#text-input").removeClass("d-none")
			$("#receiver_id").val(reciever_id);
			$("#user_name").text(user_name);
			$("#user_image").attr("src", user_image);

			socket.emit('get_messages', {
				"sender_id": sender_id,
				"reciever_id": reciever_id,
			});

		})
		$(document).on('click', '#send_message', function() {
			message = $("#chat_message").val();
			reciever_id = $("#receiver_id").val();
			sender_id = user_id;

			socket.emit("send_message", {
				sender_id: sender_id,
				reciever_id: reciever_id,
				message: message,
				chat_type: 'text'
			});
		})


		// send_message
		socket.on("response", (messages) => {
			// append single msg for chat
			if (messages.object_type == "get_message") {
				$("#chat").append(genereateChat([messages.data]));
				$("#chat_message").val('');
			} else if (messages.object_type == "get_messages") {
				// all chat append
				$("#chat").html(genereateChat(messages.data));
			}

		});

		function formatAMPM(date) {
			date = new Date(date);
			var hours = date.getHours();
			var minutes = date.getMinutes();
			var ampm = hours >= 12 ? 'PM' : 'AM';
			hours = hours % 12;
			hours = hours ? hours : 12; // the hour '0' should be '12'
			minutes = minutes < 10 ? '0' + minutes : minutes;
			var strTime = hours + ':' + minutes + ' ' + ampm;
			return strTime;
		}

	})
</script>

@endsection