$(document).ready(function(){

    function Likes(){

        this.init = function(){
            alert('hello');
        }

        this.setLike = function(){

            var urlArray = window.location.toString().split('/');
            url = '/application/index/set-like/'+urlArray[urlArray.length-2]+'/';

            $.ajax({
                url: url,
                type: "GET",
                success:function(response){
                    $('.addLike').html("<span class='glyphicon glyphicon-heart'></span>&nbsp;" + response);
                }
            });

        }

    }

    var likes = new Likes();

    $(document).on('click', '.addLike', function(){
        likes.setLike();
    });

});