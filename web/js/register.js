function previewFile() {
    const preview = document.getElementById('userimg');
    const file = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();
    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);
    if (file) {
        reader.readAsDataURL(file);
    }
}

// 该函数是鼠标交互事件触发
function cilckif(getElement, E){
    var ne = document.getElementById(E)
    getElement.onclick = ()=>{
        ne.style.display = "none";
    }
    getElement.onblur = ()=>{
        if(getElement.value == ''){
            ne.style.display = "flex";
        }else{
            ne.style.display = "none";
        }
    }
}

// 
function numberlength(a){
    a.addEventListener('blur',()=>{
        var numberlength = a.value.length;
        if(a.value !== ''){
            if(isNaN(Number(a.value))){
                alert("账号只允许使用数字，请重新输入！");
                a.value = '';
                document.getElementById("lnumber").style.display = "flex";
            }else{
                if(6 > numberlength){
                    alert("账号输入不能少于6个字符，请重新输入！");
                    a.value = '';
                    document.getElementById("lnumber").style.display = "flex";
                }else if(numberlength > 16){
                    alert("账号输入不能超过16个字符，请重新输入！");
                    a.value = '';
                    document.getElementById("lnumber").style.display = "flex";
                }
            }
        }
    })
}

// 页面加载完毕后出发的事件
window.onload = function(){
    const UserName = document.getElementById('user');
    const UserNumber = document.getElementById('number');
    const password = document.getElementById('password');
    const ConfirmPassword = document.getElementById('ConfirmPassword');
    
    cilckif(UserName, 'lname');
    cilckif(UserNumber, 'lnumber');
    numberlength(UserNumber);
    cilckif(password, 'lpd');
    cilckif(ConfirmPassword, 'lcp');
}
