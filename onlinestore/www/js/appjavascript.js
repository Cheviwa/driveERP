var ipAddress = "http://10.0.4.16:81/erp/ajax/app_ajax.php";
var prodId;
var basketId;
//            

function  onDeviceReady() {
    //alert('1');
//dialog for confirming that a product has been added to basket
    $('#getExtraItem').hide();
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 200,
        width: 200,
        modal: true,
        autoOpen: false,
        buttons: {
            "OK": function () {
                $('#wrapper1').show('fade');
                $('#showProduct').hide('slow');
                $('#productBasket').html('');
                $('#imgdiv').html('');
                 $('#quantity').val('');
                $('#totalPrice').html('');
                 $('#selectExtra').val('');

                $(this).dialog("close");
            }
        }
    });


    var productId;
    $('#showProduct').hide();
    $('#basket').show();
    $.ajax({
        url: ipAddress,
        cache: false,
        type: 'POST',
        data: {

            'request': 'getProducts'

        },
        dataType: 'json',
        success: function (data)
        {
            //displays products available to buy
            for (var i = 0; i < data.resultArray.length; i++) {
                $('#dropdowndivs').append('<tr><td onclick="viewProduct(' + data.resultArray[i].ProductId + ')">' + data.resultArray[i].ProductDescShort + '<td colspan="5" onclick="viewProduct(' + data.resultArray[i].ProductId + ')">' + '&pound' + data.resultArray[i].RRP + '</td></tr>'
                        );
            }
            productId = data.resultArray[i].ProductId;

        },
        error: function (data)
        {

            alert('error in calling ajax page');
        }

    });

}
document.addEventListener("deviceready", onDeviceReady, false);


function viewProduct(productId)
{
    //this views the product details and gives option to insert the quantity 
    $('#showProduct').show('slow');
    $('#wrapper1').hide('slow');
    //$('#popUp').show();
    productData(productId);
}
var qty;
var price;
var totsValue = 0;

function productData(productId)
{
    //shows each product's details 
    // alert(prodId);
    $.ajax({
        url: ipAddress,
        cache: false,
        type: 'POST',
        data: {

            'request': 'getSpecificProduct',
            'ProductId': productId

        },
        dataType: 'json',
        success: function (data)
        {

            $('#productBasket').append(data.resultArray[0].ProductDescShort + '<br>' + data.resultArray[0].ProductDescLong +'<br>' + 'Price:' + '&pound' + data.resultArray[0].RRP);
            $('#imgdiv').append('<img src =' + data.resultArray[0].productImagePath + ' width=120px height=120px > ');
            if(data.resultArray[0].productImagePath == null)
            {
                    $('#imgdiv').html('');  
            }
            //gets price from database
            price = data.resultArray[0].RRP;
            prodId = productId;
            prodIdspecific = data.resultArray[0].ProductId;


        },
        error: function (data)
        {

            alert('error in calling ajax page');
        }

    });
}
var extraItemId1;
var extraItemId2;
var basketItemId;
var numbExtras = 0;
function getExtraItem()
{
    //gets the extra item for speficic product and displays it in a pop up box.

    $.ajax({

        url: ipAddress,
        cache: false,
        type: 'POST',
        data: {

            'request': 'getExtraItem',
            'ProductId': prodId,
            'prodId': prodIdspecific,

        },
        dataType: 'json',
        success: function (data) {
            //if results array is empty it calls add to basket funtion and skips the extra div.
            numbExtras = data.resultArray.length;
            if (numbExtras == 0)
            {
                addtoBaskt()
            } else {
                for (var i = 0; i < data.resultArray.length; i++) {
                    $('#selectExtra').append(data.resultArray[i].ProductDescShort + data.resultArray[i].ProductId);
                    extraItemId1 = data.resultArray[0].ProductId;
                    extraItemId2 = data.resultArray[1].ProductId;
                }
                //shows div with the extra options.
                $('#getExtraItem').show('slow');

                $('#option1').html(data.resultArray[0].ProductDescShort);
//                    $('#option1').html('<input type="hidden" + id="optionId" value= '+ data.resultArray[0].ProductId + '>');
                $('#option2').html(data.resultArray[1].ProductDescShort);
                // $('#option2').html( extraItemId2);


                //             $('#dialog-message').html('Choose an extra' + '<br>' + productDesc);
                //$('#dialog-message').html('Choose an extra' + '<br>' + '<input type = "checkbox" id="extraItem" name="extra" onclick="addExtra(' + data.resultArray[i].ProductId + ')">' + productDesc + '<br>' + '<input type = "checkbox" name="extra"onclick="addExtra">' + productDesc2 + '<br>' + '<input type = "checkbox" >' + 'No extra' );
                ////                                         $("#dialog-message").dialog("open");

            }
        },
        error: function (data)
        {

            alert('error in calling ajax page');
        }

    });

}



var extraId;
function addExtraItem()
{

    //add extra Item to basketExtra table 

    var extraItem1 = $('#selectExtra').val();
    var extraItem2 = $('#option2').html();


    $.ajax({

        url: ipAddress,
        cache: false,
        type: 'POST',
        data: {

            'request': 'addExtraItem',
            'ProductId': prodId,
            'extraItem1': extraItem1,
            'extraItem2': extraItem2,
            'extraItemId1': extraItemId1,
            'extraItemId2': extraItemId2,

        },
        dataType: 'json',
        success: function (data) {
            //getting the extraId so it can be used in sql to specify where basketId ia going to be inserted
            for (var i = 0; i < data.resultArray.length; i++) {
                extraId = data.resultArray[i].ExtraId;
            }


            $('#getExtraItem').hide();
           

            addtoBaskt();


//             alert(extraId);
           
        },
        error: function (data)
        {

            alert('error in calling ajax page');
        }

    });
}

function addtoBaskt() {
    //adds selected product and quantity into the database
    //alert("hi");
    var quantity = $('#quantity').val();
    //var productId = $('#prodId').val();
    var price = $('#totalPrice').html();
    if (quantity <= 0)
    {
        alert('Must enter a quantiy above 0!');
        $('#totalPrice').html('');
         
        return;
    }

    //alert(prodId);

    $.ajax({

        url: ipAddress,
        cache: false,
        type: 'POST',
        data: {

            'request': 'addProduct',
            'ProductId': prodId,
            'quantity': quantity,
            'price': price,

        },
        dataType: 'json',
        success: function (data) {
            //makes sure if there isnt an extra basketId is not selected

            if (numbExtras == 0)
            {
                $("#dialog-confirm").dialog("open");
                $('#dialog-confirm').html("Product has been added to basket!");
                $('#quantity').val('');
                $('#totalPrice').html('');

            } else {

                $("#dialog-confirm").dialog("open");
                $('#dialog-confirm').html("Product has been added to basket!");
                  $('#quantity').val('');
                $('#totalPrice').html('');

                getBasketId();
            }

        },
        error: function (data)
        {

            alert('error in calling ajax page');
        }

    });
}

function getBasketId()
{
    //gets basketId to insert into the basketextra table
    $.ajax({

        url: ipAddress,
        cache: false,
        type: 'POST',
        data: {

            'request': 'getBasketItemId',

        },
        dataType: 'json',
        success: function (data) {
            for (var i = 0; i < data.resultArray.length; i++) {
                basketId = data.resultArray[i].BasketItemId;
            }
//            alert(basketId);
            insertBasketId();

        },
        error: function (data)
        {

            alert('error in calling ajax page');
        }

    });
}
function insertBasketId()
{
    // inserts basketId into basketExtra 
    $.ajax({

        url: ipAddress,
        cache: false,
        type: 'POST',
        data: {

            'request': 'insertBasketId',
            'basketId': basketId,
            'extraItemId1': extraItemId1,
            'extraItemId2': extraItemId2,
            'extraId': extraId

        },
        dataType: 'json',
        success: function (data) {

        },
        error: function (data)
        {

            alert('error in calling ajax page');
        }

    });
}


function calcValue()
{

    //calculates the quantity by the price and adds it to database
    //alert(price);
    var quantity = $('#quantity').val();
    if (quantity <= 0)
    {
        alert('Must enter a quantiy above 0!');
        $('#totalPrice').html('');
        
        return;
    } else {
        var Totsvalue = quantity * price;
        $('#totalPrice').html(Totsvalue);

    }
}
function Home()
{
    //goes to next page 
    window.location.href = 'index.html';
//$.mobile.pageContainer.pagecontainer("change","index.html",{transition:"slide",reverse: true});
}
function viewBasket()
{
    //goes to next page 


    window.location.href = 'basket.html';

}
function Cancel()
{
//    hides div that shows product details and shows the one that shows all the products 
    $('#showProduct').hide('slow');
    $('#wrapper1').show('slow');
    $('#quantity').val('');
    $('#productBasket').html('');
    $('#imgdiv').html('');
    $('#totalPrice').html('');
    $('#getExtraItem').hide();
}
 function takeAnImage()
 {
     window.location.href = 'camera.html';
 }

$(document).ready(function () {


    $("body").fadeIn(1000);

    $("a.transition").click(function (event) {
        event.preventDefault();
        linkLocation = this.href;
        $("body").fadeOut(1000, redirectPage);
    });

    function redirectPage() {
        window.location = linkLocation;
    }
});













