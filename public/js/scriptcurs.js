$( document ).ready(function() {

    var boto = "<button style='float: right' class='hide-show-button btn-default'><i class='fa fa-arrow-up'></i></button>";
    $('.uf').prepend(boto);

    $('.hide-show-button').on("click", function(){

        $(this).closest('.uf').find('.panel-body').slideToggle();

        if($(this).find('i').hasClass('fa-arrow-up')){
            $(this).find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
        }else{
            $(this).find('i').removeClass('fa-arrow-down').addClass('fa-arrow-up');

        }


    });

});
