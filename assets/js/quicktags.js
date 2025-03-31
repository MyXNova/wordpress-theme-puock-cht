let shortCodeColors = {'primary':'主要','danger':'錯誤','warning':'警告','info':'資訊','success':'成功','dark':'黑色'};
function genShortCodeForColor(title,colors,prefix){
    for (let color in shortCodeColors){
        let sc = prefix+color;
        if(title==="按鈕"){
            QTags.addButton( sc, shortCodeColors[color]+title, "["+sc+" href='']", "[/"+sc+"]" );
        }else{
            QTags.addButton( sc, shortCodeColors[color]+title, "["+sc+"]", "[/"+sc+"]" );
        }
    }
}
QTags.addButton( 'h2', 'H2 標籤', "<h2>", "</h2>\n" );
QTags.addButton( 'h3', 'H3 標籤', "<h3>", "</h3>\n" );
QTags.addButton( 'zyy', '引用',  "<blockquote>", "</blockquote>\n" );
QTags.addButton( 'hr', '橫線', "<hr />\n" );
QTags.addButton( 'hc', '換行', "<br />" );
QTags.addButton( 'jz', '居中', "<center>","</center>" );
QTags.addButton( 'nextpage', '換頁', '<!--nextpage-->', "" );
QTags.addButton( 'collapse', '隱藏收縮', "[collapse title='']", '[/collapse]' );
genShortCodeForColor("提示框",shortCodeColors,'t-');
let btnShortCodeColors = shortCodeColors;
btnShortCodeColors['link'] = '連結';
genShortCodeForColor("按鈕",btnShortCodeColors,'btn-');
let shortCodeIds = {
    'music':'音樂播放',
    'reply':'回覆可見',
    'login':'登入可見',
    'login_email':'登入並驗證 E-mail 可見',
};
for (let scId in shortCodeIds){
    QTags.addButton( scId, shortCodeIds[scId], "["+scId+"]", "[/"+scId+"]");
}
QTags.addButton( 'video', "視訊播放", "[video url='' autoplay=false type='auto' pic='' class='']", "[/video]");
QTags.addButton( 'download', "檔案下載", "[download file='' size='']", "[/download]");
QTags.addButton( 'password', "輸入密碼可見", "[password pass='' desc='']", "[/password]");