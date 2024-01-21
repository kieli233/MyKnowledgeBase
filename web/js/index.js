var getcookie = document.cookie;
var simolifycookie = getcookie.replace(/=/g,';');
simolifycookie = simolifycookie.replace(/[\t\r\f\n\s]/g,'');
const arr = simolifycookie.split(';');
var dict = { 'name': " " , 'img': undefined}
for( i = 0;i < arr.length; i++){
    if('name' === arr[i]){
        dict['name'] = arr[i+1];
    }
    if('img'===arr[i]){
        dict['img'] = arr[i+1];
    }
}

window.onload = function() {
    var username = document.getElementById("username");
    var userimg = document.getElementById("userimg");
    if(dict['img'] !== undefined){
        username.innerHTML = dict['name'];
        userimg.src = dict['img'];
    }
};