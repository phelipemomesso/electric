// Fix for dropdowns on mobile devices
!function ($) { 
        $(function(){
          $('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { 
              e.stopPropagation(); 
          });
          $(document).on('click','.dropdown-menu a',function(){
              document.location = $(this).attr('href');
          });
        })
      }(window.jQuery)

function portfolio_effects() {

    //To switch directions up/down and left/right just place a "-" in front of the top/left attribute
    //Vertical Sliding
    $('.boxgrid.slidedown').hover(function () {
        $(".cover", this).stop().animate({
            top: '-260px'
        }, {
            queue: false,
            duration: 300
        });
    }, function () {
        $(".cover", this).stop().animate({
            top: '0px'
        }, {
            queue: false,
            duration: 300
        });
    });
    //Horizontal Sliding
    $('.boxgrid.slideright').hover(function () {
        $(".cover", this).stop().animate({
            left: '325px'
        }, {
            queue: false,
            duration: 300
        });
    }, function () {
        $(".cover", this).stop().animate({
            left: '0px'
        }, {
            queue: false,
            duration: 300
        });
    });
    //Diagnal Sliding
    $('.boxgrid.thecombo').hover(function () {
        $(".cover", this).stop().animate({
            top: '260px',
            left: '325px'
        }, {
            queue: false,
            duration: 300
        });
    }, function () {
        $(".cover", this).stop().animate({
            top: '0px',
            left: '0px'
        }, {
            queue: false,
            duration: 300
        });
    });
    //Full Caption Sliding (Hidden to Visible)
    $('.boxgrid.captionfull').hover(function () {
        $(".cover", this).stop().animate({
            top: '160px'
        }, {
            queue: false,
            duration: 160
        });
    }, function () {
        $(".cover", this).stop().animate({
            top: '260px'
        }, {
            queue: false,
            duration: 160
        });
    });
    //Caption Sliding (Partially Hidden to Visible)
    $('.boxgrid.caption').hover(function () {
        $(".cover", this).stop().animate({
            top: '160px'
        }, {
            queue: false,
            duration: 160
        });
    }, function () {
        $(".cover", this).stop().animate({
            top: '220px'
        }, {
            queue: false,
            duration: 160
        });
    });

}



function medium_slider_top() {
    $(".medium-slider-bg").backstretch([
         baseUrl+"/default/uploads/banners/background/essentialcare.jpg", 
         baseUrl+"/default/uploads/banners/background/maquinas.jpg", 
         baseUrl+"/default/uploads/banners/background/md.jpg", 
         baseUrl+"/default/uploads/banners/background/representantes.jpg",
         baseUrl+"/default/uploads/banners/background/sala-de-imprensa.jpg",
    ], {
        duration: 10000,
        fade: 750
    });
}




function parallax_slider() {

    $('#da-slider').cslider({
        autoplay: true,
        interval: 10600
    });
}

/*function parallax() {
    $(window).scroll(function () {
        s = $(window).scrollTop();
        $(".top-parallax").css("-webkit-transform", "translateY(" + (s / 3) + "px)");
        $(".top-parallax").css("-o-transform", "translateY(" + (s / 3) + "px)");
        $(".top-parallax").css("-moz-transform", "translateY(" + (s / 3) + "px)");
        $(".top-parallax").css("-ms-transform", "translateY(" + (s / 3) + "px)");
        $(".top-parallax").css("transform", "translateY(" + (s / 3) + "px)");
    });
}*/

function clients() {

    $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: true,
        itemWidth: 140,
        itemMargin: 6,
        minItems: 1,
        maxItems: 6,
        controlNav: true,
        directionNav: false
    });
}

function large_navbar_change() {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 650) {
            $('.navbar-default').css('background', '#ffffff');
        } else if ($(window).scrollTop() < 650) {
            $('.navbar-default').css('background', 'none');
        }
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() > 630) {
            $('.navbar .nav > li > a').css('color', '#000000');
            $('.navbar-brand').css('color', '#000000');
        } else if ($(window).scrollTop() < 630) {
            $('.navbar .nav > li > a').css('color', '#ffffff');
            $('.navbar-brand').css('color', '#ffffff');
        }
    });
}

function navbar_change() {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 350) {
            $('.navbar-default').css('background', '#ffffff');
        } else if ($(window).scrollTop() < 350) {
            $('.navbar-default').css('background', 'none');
        }
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() > 330) {
            $('.navbar .nav > li > a').css('color', '#000000');
            $('.navbar-brand').css('color', '#000000');
        } else if ($(window).scrollTop() < 330) {
            $('.navbar .nav > li > a').css('color', '#ffffff');
            $('.navbar-brand').css('color', '#ffffff');
        }
    });
}

function medium_navbar_change() {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 500) {
            $('.navbar-default').css('background', '#ffffff');
        } else if ($(window).scrollTop() < 500) {
            $('.navbar-default').css('background', 'none');
        }
    });
    $(window).scroll(function () {
        if ($(window).scrollTop() > 480) {
            $('.navbar .nav > li > a').css('color', '#000000');
            $('.navbar-brand').css('color', '#000000');
        } else if ($(window).scrollTop() < 480) {
            $('.navbar .nav > li > a').css('color', '#ffffff');
            $('.navbar-brand').css('color', '#ffffff');
        }
    });
}

function map() {
    new GMaps({
        div: '#map',
        lat: 40.71435,
        lng: -74.00597,
        scrollwheel: false
    });
}

function image_top() {
    $(".slider-bg").backstretch("img/big/big-5.jpg");
}

function slider() {
    $('.flexslider').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: false
    });
}

function video() {
    $("#video").fitVids();
}

function photo_grid() {
	$('.photoset-grid-lightbox').photosetGrid({
		  highresLinks: true,
		  rel: 'withhearts-gallery',
		  gutter: '2px',

		  onComplete: function(){
		    $('.photoset-grid-lightbox').attr('style', '');
		    $('.photoset-grid-lightbox a').colorbox({
		      photo: true,
		      scalePhotos: true,
		      maxHeight:'90%',
		      maxWidth:'90%'
		    });
		  }
		});
}

function countdown() {
    "use strict";

    $('time').countDown({
        with_separators: false
    });

    $('.cd').countDown({
        css_class: 'countdown'
    });
}

$(".telefone").mask("(99) 9999-9999");
$(".cnpj").mask("99.999.999/9999-99");
$(".cpf").mask("999.999.999-99");
$("#cep").mask("99999-999");

$('#telefone_celular').focusout(function(){
        var phone, element;
        element = jQuery(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if(phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    }).trigger('focusout');


$(".btn-comprar").on( "click", function( e ) {

    e.preventDefault();

    jQuery.ajax({

        url: baseUrl+'/carrinho/add',
        dataType: 'html',
        type: 'POST',
        data: {

            cod_produto : $(this).attr("id"),
            qtde : 1
        },

        success: function(data) {               

            location.href=baseUrl+"/carrinho";
        },
        error: function(xhr, er) {
            alert('Error ' + xhr.status + ' - ' + xhr.statusText);
        }
    });  
}) 

$("#btn-comprar-grupo").on( "click", function( e ) {

    e.preventDefault();

    jQuery.ajax({

        url: baseUrl+'/carrinho/add',
        dataType: 'html',
        type: 'POST',
        data: {

            cod_produto : $("#prod-grupo").val(),
            qtde : $("#qtde-grupo").val()
        },

        success: function(data) {               

            alert('Produto adicionado com sucesso ao carrinho de compras!');
        },
        error: function(xhr, er) {
            alert('Error ' + xhr.status + ' - ' + xhr.statusText);
        }
    });  
}) 

$(".btn-comprar-grid").on( "click", function( e ) {

    e.preventDefault();

    $id = $(this).attr("id");
    $estoque = $("#estoque-"+$id).text();
    $qtde = $("#qtde-"+$(this).attr('id')).val();

    if ($qtde == 0) {

        alert('A quantidade precisar ser maior que zero!');
        return false;
    } 

    if (parseInt($estoque) < $qtde ) {

        $("#qtde-"+$(this).attr('id')).val(0) ;
        alert('A quantidade informada nao pode ser maior que o estoque!');
        return false;

    } else {    
    
        var disp = verificaEstoque($id,$qtde);

        disp.success(function (data) {
            
            if (data == 2) {
            
                alert('Este produto não tem mais estoque disponível para compra.');
                $("#tr-"+$id).addClass("danger");
                $("#qtde-"+$id).val(0);
        
            } else {    

               $("#tr-"+$id).addClass("success");

                jQuery.ajax({

                    url: baseUrl+'/carrinho/add',
                    dataType: 'html',
                    type: 'POST',
                    data: {

                        cod_produto : $id,
                        qtde : $qtde
                    },

                    success: function(data) {               

                        
                        //alert('Produto adicionado com sucesso ao carrinho de compras!');


                    },
                    error: function(xhr, er) {
                        alert('Error ' + xhr.status + ' - ' + xhr.statusText);
                    }
                });
            }

        });

    }  
})

function verificaEstoque($produto,$qtde){

    return jQuery.ajax({

        url: baseUrl+'/carrinho/disponibilidade',
        dataType: 'html',
        type: 'POST',
        data: {

            cod_produto : $produto,
            qtde : $qtde
        },

        success: function(data) {               

        
        },
        error: function(xhr, er) {
            alert('Error ' + xhr.status + ' - ' + xhr.statusText);
        }
    });

}

$(".btn-delete").on( "click", function( e ) {

    e.preventDefault();

    jQuery.ajax({

        url: baseUrl+'/carrinho/delete',
        dataType: 'html',
        type: 'POST',
        data: {

            cod_produto : $(this).attr("rel")
        },

        success: function(data) {               

           location.href=baseUrl+"/carrinho";
        },
        error: function(xhr, er) {
            alert('Error ' + xhr.status + ' - ' + xhr.statusText);
        }
    });  
})    

$(".btn-update").on( "click", function( e ) {

    e.preventDefault();

    var $id = $(this).attr("rel");
    var $estoque = $("#estoque-"+$id).val();
    var $qtde = $("#qtde-"+$id).val();

    if (parseInt($estoque) < $qtde ) {

        $("#qtde-"+$(this).attr('id')).val(0) ;
        alert('A quantidade informada nao pode ser maior que o estoque!');
        return false;

    } else {

        var disp = verificaEstoque($id,$qtde);

        disp.success(function (data) {
            
            if (data == 2) {
            
                alert('Este produto não tem mais estoque disponível para compra.');
                location.href=baseUrl+"/carrinho";
            } else {    

                jQuery.ajax({

                    url: baseUrl+'/carrinho/update',
                    dataType: 'html',
                    type: 'POST',
                    data: {

                        cod_produto : $id,
                        qtde : $qtde
                    },

                    success: function(data) {               

                      location.href=baseUrl+"/carrinho";
                    },
                    error: function(xhr, er) {
                        alert('Error ' + xhr.status + ' - ' + xhr.statusText);
                    }
                });
            }
        })            
    }  
}) 


$('#cep').on( "blur", function( e ) {
        
    e.preventDefault();
        
    if ($('#cep').val()!='' && $('#cep').val()!='_____-___') {
        
        $.ajax({
            
            url: baseUrl+'/cadastro/consultacep/cep/'+$('#cep').val(),
            dataType: 'html',
            type: 'get',

            success: function(data) {               
                    
                var n = data.split("+")
                    
                if(n[0]==0){
                    
                    alert('CEP não encontrado.');
                       
                } else if(n[0]==1){
                    
                    $("#endereco").val(unescape(n[1]));
                    $("#bairro").val(unescape(n[2]));
                    $("#cidade").val(unescape(n[3]));
                    $("#estado").val(unescape(n[4]));
                    $("#numero").focus();
                }    
            },
            
            error: function(xhr, er) {
                
                alert('Error ' + xhr.status + ' - ' + xhr.statusText);
                
            }
        });
        
    } else {
            
        alert('Preencha o CEP !');
    }
        
}); 

$('.frete').on( "click", function( e ) { 

    var $valorFrete = $(this).val();
    var $valorCompra = $('#compra').val();
    var $tipoFrete = $(this).attr('id');

    jQuery.ajax({

        url: baseUrl+'/carrinho/frete',
        dataType: 'html',
        type: 'POST',
        data: {

            valorFrete : $valorFrete,
            valorCompra : $valorCompra,
            tipoFrete : $tipoFrete
        },

        success: function(data) {               

            $('#totalCompra').html(data);
        },
        error: function(xhr, er) {
            alert('Error ' + xhr.status + ' - ' + xhr.statusText);
        }
    
     });


}); 

$('#bt-password').on("click",function(e){

    e.preventDefault();

    if ($('#email').val() == '')
        alert('O E-mail é obrigatório.');
    else
        $('#form-password').submit(); 
}); 

$('.popover-info').popover({

    html: true,
    placement: 'left',
    trigger: 'hover'
});


$("#btn-paypal").on( "click", function( e ) {

    e.preventDefault();

    $("#overlay-paypal").css("visibility","visible");
    $( "#form-paypal" ).submit();
}) 

$('.collapse').collapse();
