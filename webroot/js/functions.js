function subscribe(){
  $('#subscribe').modal('show');
}

$(document).ready(function(){
  setTimeout(subscribe, 10000);
});

$( ".advertisement" ).mouseover(function() {
      $( ".norm_price", this ).css( "display","none");
      $( ".discount", this ).css( "display","inline");
    })
    .mouseout(function() {
      $( ".norm_price", this ).css( "display","inline");
      $( ".discount", this ).css( "display","none");
    });

$(document).ready(function(){
    $(".advertisement").popover({
        title: 'Получи скидку - 10% !',
        content: 'Номер купона: FjE5jK',
        trigger: 'hover',
        placement: 'bottom'
    });
});
$(document).ready(function() {
    $('.advertisement').click(function() {
        var id = $(".hidden", this).text();
        var prelink=$("#prelink").text();
        $.post(prelink+'main/ajax_adv',{id: id});
    });
});

