/* globals Chart:false, feather:false */

(function () {
    'use strict'
  
    feather.replace()
  
  })()
  

function getToken (){

    return $.ajax({
      url : "/user/get-token",
      method : "GET",
      async : true,
      dataType : 'json',
      success: function(data){
  
        const now = new Date()
        
        var x = 1;
        setCookie('token',data.data,x)
        setCookie("token_ttl", now.getTime() + (x * 24 * 60 * 60 * 1000),x)
        setTimeout(function () {
  
          mainLoad()
          }, 1000);
      }
    });
  }
  


function setCookie (name, value, ex) {

    var expires = "";
  
    var date = new Date();
    date.setTime(date.getTime() + (ex * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toUTCString();
  
    document.cookie = name + "=" + (value || "") + expires + "; path=/; "+ " SameSite=LAX;";
}
  
  // get cookie function
function getCookie (name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie (name) { 

    document.cookie = name+'=; Path=/; Max-Age=-99999999;';  
}


$(function() {
  
    var token = getCookie('token_ttl')
  
    if (token){
  
      const now = new Date().getTime()
      const newToken = token - (20*60*60*1000)
  
      if (now > newToken) {
  
          checkTokenError()
      }
    }
});


function checkToken(){

    var id = $(".globalId").attr("id");
  
    return $.ajax({
      url : "/api/users-check?id="+id,
      method : "GET",
      async : true,
      dataType : 'json',
      success: function(data){
        
        return data.data
      },
      error:function (data){
  
        //setTimeout(function () {
  
          checkTokenError()
        //}, 2000);
      }
    });
  }
  
function checkTokenError () {
    
    var token = getCookie('token')

    if (token) {

        eraseCookie('token')
        eraseCookie('token_ttl')
    }

    $.when(getToken()).done(function (gt) {

        if (gt)
        setupHeader()
    });   
}

setupHeader()

function setupHeader (){

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer '+window.getCookie('token'),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}
  

function getDataTables (url,col) {

  $('.dataTables').DataTable({

    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: url,
      error: function (jqXHR, textStatus, errorThrown) {
         
        console.log(errorThrown)
        if(errorThrown === 'Unauthorized'){

            window.reCallTable(url,col)
        }    
      }
    },
    columns: col
  });
}

function reCallTable (url,col) {

  $('.dataTables').DataTable().destroy();
  getDataTables(url,col)
}
