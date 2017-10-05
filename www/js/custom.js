function check_space(input_val , div_id)
    {
        if(input_val.trim().length==0)
        {
            $("#"+div_id).html("Please Enter The Value");
            $("#register-btn").prop('disabled' , true);
            
            
        }
        else{
            $("#"+div_id).empty();
            $("#register-btn").prop('disabled' , false);
        }
        
    }
    (function () {

    var $button = $("<div id='source-button' class='btn btn-primary btn-xs'>&lt; &gt;</div>").click(function () {
      var index = $('.bs-component').index($(this).parent());
      $.get(window.location.href, function (data) {
        var html = $(data).find('.bs-component').eq(index).html();
        html = cleanSource(html);
        $("#source-modal pre").text(html);
        $("#source-modal").modal();
      })

    });

    $('.bs-component [data-toggle="popover"]').popover();
    $('.bs-component [data-toggle="tooltip"]').tooltip();

    $(".bs-component").hover(function () {
      $(this).append($button);
      $button.show();
    }, function () {
      $button.hide();
    });

    function cleanSource(html) {
      var lines = html.split(/\n/);

      lines.shift();
      lines.splice(-1, 1);

      var indentSize = lines[0].length - lines[0].trim().length,
          re = new RegExp(" {" + indentSize + "}");

      lines = lines.map(function (line) {
        if (line.match(re)) {
          line = line.substring(indentSize);
        }

        return line;
      });

      lines = lines.join("\n");

      return lines;
    }

    $(".icons-material .icon").each(function () {
      $(this).after("<br><br><code>" + $(this).attr("class").replace("icon ", "") + "</code>");
    });

  })();

$(function () {
    $.material.init();
    $(".shor").noUiSlider({
      start: 40,
      connect: "lower",
      range: {
        min: 0,
        max: 100
      }
    });

    $(".svert").noUiSlider({
      orientation: "vertical",
      start: 40,
      connect: "lower",
      range: {
        min: 0,
        max: 100
      }
    });
  });


 var pcount=1;
 var pmin_length = 9;
 var pstart=0;
 function phonecheck() {
    $('#register_wait').css('display','block');
    var phone=$('#register_phone').val();
        
    var keyword = $('#register_phone').val();
    if (keyword.length >= pmin_length) {
        var mbaseUrl=$('#baseUrl').attr('value');
        $.ajax({
            url: mbaseUrl+'/index/phonecheck',
            type: 'POST',
            data: {keyword:keyword },
            success:function(data)
            {
              var data = $.parseJSON(data); 
              $('#register_wait').css('display','none');  
              pcount=data;
              if(pcount==1)
              {
                $('#register_phone_error').html("Number already registered");
                $("#register_phone_error").focus().css({ "color": "#FF1F2E"});
                $('#register-btn').prop('disabled', true);
                
              }
              if(pcount==0){
                $("#register_phone_error").focus().css({ "color": "#rgb(19, 183, 8)"});
                $('#register-btn').prop('disabled', false);
              }
            }
        });
    } 
    else {
        $('#register_phone_error').hide();
    }
        
 } 
  $(document).ready(function(){
                var mbaseUrl=$('#baseUrl').attr('value');
                $('input.typeahead').typeahead({
                    name: 'typeahead',
                    remote: mbaseUrl+'/ajax/search?key=%QUERY',
                    listeners: {
                       select: function(value){
                        alert(value);
                        console.log(value,'dsfsdf');
                       }
                    }
                });
                $('.typeahead').on('typeahead:selected', function(event, datum) {
                  var v = datum.value;
                  // alert(v);
                  // console.log(v,'dsfsdf');
                   window.location.href = mbaseUrl+'/product/search?search='+v;
                });
            });
   $(document).ready(function() {
 
  var owl = $("#owl-demo");
 
  owl.owlCarousel({

      items : 10, //10 items above 1000px browser width
      itemsDesktop : [1000,5], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,3], // betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
     
  });
 
  // Custom Navigation Events
  $(".next").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev").click(function(){
    owl.trigger('owl.prev');
  })
  $(".play").click(function(){
    owl.trigger('owl.play',1000); //owl.play event accept autoPlay speed as second parameter
  })
  $(".stop").click(function(){
    owl.trigger('owl.stop');
  })
 
});