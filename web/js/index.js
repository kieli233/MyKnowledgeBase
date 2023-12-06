var getcookie = document.cookie;
var simolifycookie = getcookie.substring(getcookie.indexOf(';')+1);
simolifycookie = simolifycookie.replace(/=/g,';');
const arr = simolifycookie.split(';');
const dict = { 'name': arr[1] , 'img': arr[3]}

window.onload = function() {
    var username = document.getElementById("username");
    var userimg = document.getElementById("userimg");
    if(dict['img'] !== undefined){
        username.innerHTML = dict['name'];
        userimg.src = dict['img'];
    }
};