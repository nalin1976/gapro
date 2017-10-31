/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var path = "";
if(document.location.port == ""){
     path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];

}else{
    path = document.location.protocol+'//'+document.location.hostname+':'+document.location.port+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
}

alert(path);

