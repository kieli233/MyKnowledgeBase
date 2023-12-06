# PHP+html创建一个小web

edition: 0.1 -beta

本文中的PHP代码是由本人用PHP4版本写，能正常运行，然后经AI改造后，修修补补完成的，能在PHP8.2下正常运行，安全性未知，请不要把这个当你自己的网站，而且我本人也没解决debian 11和12上没办法上传文件的问题。而且这里也找了很多大佬的css UI，我自己没什么创新能力，所以UI写得很烂（注册那页我不知道怎么写，于是开摆）。

## 文件接口  
背景在设置在picture中，用户上传的头像设置在img文件里，上传名字是用时间戳后五位+账号，具体可以看[register.php](./php/register.php)里的处理上传部分。

index.css中`.body`下`background`是设置主页(index.html)的背景图片  
login, register和forget的设置和index.css基本一致,都需要你们自己去弄背景图片，懒得话，直接复制到picture下，改名字就行，这我不提供背景图片。

### 登录  
login.html -> login.php -> index.html  
- login.html  
    由form提交账号和密码到login.php中
- login.php  
    接收html提交的数据，经过sql.php连接数据库，然后查询账号是否存在，如果不存在就提示账号或密码出错，这里可以提示清楚，但是为了安全一般不会提醒很清晰给你，都是给一个模糊的答案。查询到了，之后进入<span title="为什么不直接用账号和密码查询的原因是我给密码加密，直接用明码查询能查到，那加密的意义是什么。">[密码校验](#)</span>，密码校验完成之后就可以把用户名和用户头像加到cookie中。
- index.html  
    查询cookie中是否有数据，如果没有就使用默认图片。

### 注册
register.html -> register.php -> index.html
- register.html  
    由form提交用户输入到register.php中
- register.php  
    分区块看。  
    1. 首先是上传图片检测区块，这个主要是检查用户上传是否为图片，上传的是图片会检查是否上传成功，如果上传失败会提醒用户，如果上传的不是图片会提示用户提交的不是一张图片。  
    2. 然后到判断用户是否存在，如果用户名称或账号存在重复就提醒用户，账号或名称存在重复，并删除掉已经上传的图片，如果没有重复就直接写入数据库中，完成写入之后，设置cookie，然后直接跳转到index.html
- index.html  
    查询cookie中是否有数据，如果没有就使用默认图片。

### 忘记密码
forget.html -> forget.php -> login.html  
- forget.html  
    由form提交用户输入到forget.php中
- forget.php  
    检查用户账号和手机号，数据库匹配上了就执行更新，更新用户的密码。
- login.html  
    登录

### sql.php
连接数据库用的代码，因为重复性很高干脆就单独拉出来做一个文件，需要注意的是， 在每一个数据的PHP中需要手动关闭。
![后果](/img/php不执行关闭sql连接的后果.png)