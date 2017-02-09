   var ipAddress = "http://10.0.4.16:81/erp/ajax/app_ajax.php";
   var totsValue = 0;
   var basketItemId;

//  var basketId;
   function  onDeviceReady() {
 $('#checkoutBtn').hide();
$('#bsktTable').show();
$('#prodHeadr').show('slow');
//gets products and extras in the basket and displays them in a table.
                $.ajax({

                    url: ipAddress,
                    cache: false,
                    type: 'POST',
                    data: {

                        'request': 'viewBasket',

                    },
                    dataType: 'json',
                    success: function (data)
                    {
                         
                        for (var i = 0; i < data.resultArray.length; i++) {
                            $('#bsktTable').append('<tr><td >' + data.resultArray[i].ProductDescShort + '<td>' + data.resultArray[i].quantity + '<td id="priceBskt">' + '&pound' + data.resultArray[i].itemValue + '<td>' + "<img src='images/delete.png'width=45px height=45px onclick='deleteItem(" + data.resultArray[i].BasketItemId + ")'>" + '</td></tr>');
                            if (data.resultArray[i].ExtraId != null)
                            {
                                $('#bsktTable').append('<tr><td id="basketTds" "colspan="2">' + 'Extra Sauce: ' + data.resultArray[i].extraDesc + '</td></tr>');
                            }
//                            productId = data.resultArray[i].ProductId;
                            totsValue += data.resultArray[i].itemValue << 0;
                        }
                         
//                   alert(totsValue);
                        $('#value').html("Total" + '&nbsp;' + '&pound' + totsValue);
                        $('#checkoutBtn').show();
                        $('#backToMenu').show();
                        
                     
                       

                    },
                    error: function (data)
                    {

                        alert('error in calling ajax page');
                    }

                });
            }
      
             
            function Home()
            {
                //goes back to homepage
                window.location.href = 'index.html';
            }
            
            document.addEventListener("deviceready", onDeviceReady, false);

            function deleteItem(basketId)
            {
               //deletes each item picked and also deletes extras.
                $.ajax({

                    url: ipAddress,
                    cache: false,
                    type: 'POST',
                    data: {

                        'request': 'deleteItem',
                        'BasketId': basketId,
                    

                    },
                    dataType: 'json',
                    success: function (data)
                    {
            window.location.href = 'basket.html';
 
            
                    },
                    error: function (data)
                    {

                        alert('error in calling ajax page');
                    }

                });
            }
            $(document).ready(function() {
 
 //creates a fade when you go to the next page
    $("body").fadeIn(1500);
 
    $("a.transition").click(function(event){
        event.preventDefault();
        linkLocation = this.href;
        $("body").fadeOut(1000, redirectPage);      
    });
         
    function redirectPage() {
        window.location = linkLocation;
    }
});
function CheckOut()
{

    if(totsValue < 5)
    {
        alert("Minimum order is"  + '\u00A3' + '5!'  );
        return;
    }
$('#checkOutFrm').show();
$('#bsktTable').hide();
$('#checkoutBtn').hide();

 }  
