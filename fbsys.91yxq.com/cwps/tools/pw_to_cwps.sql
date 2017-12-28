#此脚本用于把pw的会员数据一次性导入到cwps中
#注意，需要先自行清空cwps_user表中的所有记录，导入后，使用pw的管理员进行登录

TRUNCATE TABLE `cwps_user`;


#插入主要会员信息，如有需要请自行修改cwps中的目标表名(CWPS_USER), 和dz中的来源表名(pw_members)，比如表名前缀不是默认的时候
#注意，如果PHPWind和cwps数据库不是同一个，请修改pw_members为phpwind.pw_members,也就是库名.表名
INSERT INTO `cwps_user` (UserID,UserName,NickName,Status,Password,Gender,GroupID,RegisterDate,Email,Birthday,PassQuestion,PassAnswer,SubGroupIDs,RoleID,SubRoleIDs) SELECT uid,username,username,1,password,gender,groupid,regdate,email,bday,'','','',2,'' FROM `pw_members`;

#把pw管理员组3的全部改成cwps的组0
UPDATE `cwps_user` SET GroupID=0  Where GroupID = 3;
#把不是0会员组，全部改成cwps的一般会员组3
UPDATE `cwps_user` SET GroupID=3  Where GroupID != 0;
#把不是pw管理员组3的会员组，全部改成cwps的一般会员组3
UPDATE `cwps_user` SET GroupID=2  WHERE GroupID = 0;



#清空附加会员表
TRUNCATE TABLE `cwps_user_extra`;

#插入附加会员关联记录，如有需要请自行修改cwps中的目标表名(CWPS_USER)和(cwps_user_extra)
INSERT INTO `cwps_user_extra` (UserID)  SELECT UserID FROM `cwps_user`;