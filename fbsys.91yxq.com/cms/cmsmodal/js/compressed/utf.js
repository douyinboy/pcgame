function utf16to8(str){var out,i,j,len,c,c2;out=[];len=str.length;for(i=0,j=0;i<len;i++,j++){c=str.charCodeAt(i);if(c<=0x7f){out[j]=str.charAt(i);}
else if(c<=0x7ff){out[j]=String.fromCharCode(0xc0|(c>>>6),0x80|(c&0x3f));}
else if(c<0xd800||c>0xdfff){out[j]=String.fromCharCode(0xe0|(c>>>12),0x80|((c>>>6)&0x3f),0x80|(c&0x3f));}
else{if(++i<len){c2=str.charCodeAt(i);if(c<=0xdbff&&0xdc00<=c2&&c2<=0xdfff){c=((c&0x03ff)<<10|(c2&0x03ff))+0x010000;if(0x010000<=c&&c<=0x10ffff){out[j]=String.fromCharCode(0xf0|((c>>>18)&0x3f),0x80|((c>>>12)&0x3f),0x80|((c>>>6)&0x3f),0x80|(c&0x3f));}
else{out[j]='?';}}
else{i--;out[j]='?';}}
else{i--;out[j]='?';}}}
return out.join('');}
function utf8to16(str){var out,i,j,len,c,c2,c3,c4,s;out=[];len=str.length;i=j=0;while(i<len){c=str.charCodeAt(i++);switch(c>>4){case 0:case 1:case 2:case 3:case 4:case 5:case 6:case 7:out[j++]=str.charAt(i-1);break;case 12:case 13:c2=str.charCodeAt(i++);out[j++]=String.fromCharCode(((c&0x1f)<<6)|(c2&0x3f));break;case 14:c2=str.charCodeAt(i++);c3=str.charCodeAt(i++);out[j++]=String.fromCharCode(((c&0x0f)<<12)|((c2&0x3f)<<6)|(c3&0x3f));break;case 15:switch(c&0xf){case 0:case 1:case 2:case 3:case 4:case 5:case 6:case 7:c2=str.charCodeAt(i++);c3=str.charCodeAt(i++);c4=str.charCodeAt(i++);s=((c&0x07)<<18)|((c2&0x3f)<<12)|((c3&0x3f)<<6)|(c4&0x3f)-0x10000;if(0<=s&&s<=0xfffff){out[j]=String.fromCharCode(((s>>>10)&0x03ff)|0xd800,(s&0x03ff)|0xdc00);}
else{out[j]='?';}
break;case 8:case 9:case 10:case 11:i+=4;out[j]='?';break;case 12:case 13:i+=5;out[j]='?';break;}}
j++;}
return out.join('');}