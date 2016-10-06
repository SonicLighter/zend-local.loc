$(document).ready(function(){

    function UserEdit(){

        this.init = function(){
            //var value = document.getElementById('selectRole').value;
            //alert('dfoij');
            //alert('aodsop');
            //alert($('#userRole').val());
        }

        /*
        this.getPressedOption = function(value){
            alert(value);
        }
        */

        this.changeValue = function(){

            $('#userRole').val($('#selectRole').val());

        }

    }

    var userEdit = new UserEdit();
    userEdit.init();

    $(document).on('click', '#selectRole', function(){
        //alert($('#selectRole').val());
        userEdit.changeValue();
    });

});
