$().ready(function(){

	$('#statusArea').autosize();
	
	// ajax post status
	$('#newStatusForm').submit(function(event){
		event.preventDefault();
		var $form = $( this ),
    	data = $form.serialize(),
    	url = $form.attr( "action" );

    	var posting = $.post( url, { formData: data } );

    	posting.done(function(data){
    		if(data.success){
    			$('#statusArea').val('');
    			$("#post").attr({ disabled:false, value:"Post" });
    			$('div.posts').prepend(data.html);
    		}
    		if(data.fail){
    			alert('fail');
    		}
    	});
	});

	$('#newFriendPostForm').submit(function(event){
		event.preventDefault();
		var $form = $( this ),
    	data = $form.serialize(),
    	url = $form.attr( "action" );

    	var posting = $.post( url, { formData: data } );

    	posting.done(function(data){
    		if(data.success){
    			$('#statusArea').val('');
    			$("#post").attr({ disabled:false, value:"Post" });
    			$('div.posts').prepend(data.html);
    		}
    		if(data.fail){
    			alert('fail');
    		}
    	});
	});

	// ajax comment on post
	$('body').on('keypress', function(event){
		// for autisizing comment box
		$('textarea._commentTxtArea').autosize().css('height', 'auto');

		// when pressed enter user submit comment
		// enter+shift = new line in comment box
		if($('textarea._commentTxtArea').is(':focus')){
			if(event.which == 13 && event.shiftKey){
				event.preventDefault();
				var $focused = $(':focus');
				$focused.val( $focused.val() + "\n");
			}
			else if ($('textarea._commentTxtArea').is(':focus')){
				if(event.which == 13){
					event.preventDefault();
					$('textarea._commentTxtArea').autosize().css('height', 'auto');
					var focused = $(':focus');
					var parentForm = focused.closest('form').serialize();
					sendComment(parentForm);
				}
			}
		}
	});

	// sends comment text and returns comment HTML
	function sendComment(serializedForm){
		var data = serializedForm;
		var url = 'http://www.lovebook.com/newComment';

		var posting = $.post( url, { formData: data } );

		posting.done(function(data){
    		if(data.success){
    			var prependTo = 'div#' + data.comments;
    			$(prependTo).append(data.comment);
    			$( document.activeElement ).val('').blur();
    		}
    		if(data.fail){
    			alert('fail');
    		}
    	});
	}

	function likePost(_postID){
		var url = 'http://www.lovebook.com/likePost';
		var _data = {postID: _postID};
		$.ajax({
		    type: "POST",
		    url: "http://www.lovebook.com/likePost",
		    data: _data,
		    dataType: 'json',
		    contentType: 'application/json',
		    success: function(data){
		        console.log(data.postID_);
		    }
		});
	}

	$('body').on('click', 'a._likeAnchor', function(){
		event.preventDefault();
		var likedPostID = Number($(this).attr('id').substring(4));
		var _data = { 'postID': likedPostID };
		$.ajax({
		    type: "POST",
		    url: "/likePost",
		    data: JSON.stringify(_data),
		    dataType: 'json',
		    contentType: 'application/json',
		    success: function(response){
		        if(response.liked == false){
		        	$(response.anchor).text('Unlike');
		        	var likeCountSpanID = '#likeCount' + likedPostID;
		        	var value = parseInt($(likeCountSpanID).text(), 10) + 1;
					$(likeCountSpanID).text(value);
		        }
		        else if(response.liked == true){
		        	$(response.anchor).text('Like');
		        	var likeCountSpanID = '#likeCount' + likedPostID;
		        	var value = parseInt($(likeCountSpanID).text(), 10) - 1;
					$(likeCountSpanID).text(value);
		        }
		    }
		});
	});

	$('body').on('click', 'a._commentAnchor', function(){
		event.preventDefault();
		var commentTextareaID = $(this).attr('href');
		$(commentTextareaID).focus();
	});

	$('body').on('click', 'a._showLikesAnchor', function(){
		event.preventDefault();
		
		var childSpan = $(this).find('span.likeCount');
		var _postID = Number(childSpan.attr('id').substring(9));
		var _data = { 'postID': _postID };
		$.ajax({
		    type: "POST",
		    url: "/getUsersThatLiked",
		    data: JSON.stringify(_data),
		    dataType: 'json',
		    contentType: 'application/json',
		    success: function(response){
		    	$(response.html).modal();
		    }
		});
	});
})