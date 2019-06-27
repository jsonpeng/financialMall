<style type="text/css">
		.container .product-title {
		  padding: 16px 0;
		  font-size: 18px;
		  text-align: center;
		  background-color: #fff;
		  margin-bottom: 16px;
		}
		.container .product-banner {
		  background: url({{ asset('images/sharedk/banner2.jpg') }}) no-repeat center center;
		  background-size: cover;
		  padding: 35px 0;
		  text-align: center;
		  position: relative;
		}
		.container .product-banner p {
		  font-size: 18px;
		  font-weight: 600;
		  color: #fff;
		  margin-top: 10px;
		}
		.container .product-banner img{
			height:60px;
		}
		.container .product-banner .sell-sum {
		  position: absolute;
		  font-size: 14px;
		  line-height: 28px;
		  color: #8cbfff;
		  top: 19px;
		  right: 20px;
		}
		.container .product-banner .sell-style {
		  position: absolute;
		  background: url({{ asset('images/sharedk/icon12.png') }}) no-repeat center center;
		  background-size: cover;
		  left: 0;
		  top: 0;
		  width: 55px;
		  height: 20px;
		  font-size: 14px;
		  line-height: 20px;
		  font-weight: 600;
		  color: #fff;
		}
		.container .profit{
		  margin-bottom: 16px;
		  background-color: #fff;
		}
		.container .profit-model{
		  padding:8px 8px 14px 8px;
		  display:flex;
		  justify-content: space-between;
		  align-items: center;
		}
		.container .profit-model .profit-head{
		  display: flex;
		  align-items: center;
		  box-sizing: border-box;
		  
		}
		.container .profit-model .profit-head p{
		  /*display: inline-block;*/
		  margin-left: -5px;
		  padding-right: 20px;
		  padding-left: 10px;
		  font-size: 14px;
		  line-height: 22px;
		  height:22px;
		  font-weight: bold;
		  color:#fff;
		  border-top-right-radius: 15px;
		  border-bottom-right-radius: 15px;
		  box-sizing: border-box;
		  background: -webkit-gradient(linear, left top, right top, from(#60b3f8), to(#527ee0));
		}
		.container .profit-model .profit-head img{
			width:40px;
			height:41px;
			margin-bottom: 7px;
		  	z-index: 10;
		  
		}
		.container .profit-model .profit-remark{
		  font-size:12px;
		  color:#999;
		}
		.container .profit-model .profit-remark span{
		  color:#fe5d4f;
		}
		.container .profit-model .profit-remark a{
		  color:#5383e2;
		  font-size: 12px;
		  text-decoration: none;
		}
		.container .profit-flow{
		  display: flex;
		  justify-content: space-around;
		  /*padding:0 8px;*/
		}
		.container .profit-flow .arrow{
		  width:25px;
		  height:16px;
		  margin-top: 17px;
		}
		.container .profit-flow .step{
		  display: flex;
		  flex-direction: column;
		  align-items: center;
		  flex:1;
		}
		.container .profit-flow .step img{
			width:50px;
			height:50px;
		}
		.container .profit-flow .step p{
		  
		  margin-top: 10px;
		  margin-bottom: 22px;
		  font-size: 13px;
		}
		.container .reward-list{
		  display: flex;
		  justify-content: space-between;
		  flex-wrap: wrap;
		  /*padding:0 20px;*/
		}
		.container .reward-list .reward-item {
		  width:50%;
		  padding:32px 0;
		  background:url({{ asset('images/sharedk/brain.png') }} ) no-repeat center center;
		  background-size: cover;
		  margin-bottom:9px;
		}
		.container .reward-list .reward-item h4{
		  font-size: 20px;
		  font-weight: 600;
		  color:#11409e;
		  text-align:center;
		}
		.container .reward-list .reward-item p{
		  font-size: 14px;
		  text-align:center;
		}
		.container .reward-close{
		  display: flex;
		  justify-content: center;
		  align-items: center;
		  padding-top:12px;
		  padding-bottom: 20px;
		}
		.container .reward-close img{
			width:18px;
			height:21px;
		}
		.container .reward-close div{
		  font-size: 16px;
		  margin-left: 6px;
		}
		.container .skip-bottom{
		  padding:16px 0 22px 0;
		  text-align:center;
		}
		.container .skip-bottom a{
		  background:-webkit-gradient(linear, left top, right top, from(#60b3f8), to(#527ee0));
		  display: inline-block;
		  width:210px;
		  height:50px;
		  font-size: 18px;
		  line-height: 50px;
		  color:#fff;
		  border-radius: 25px;
		}



		.page .applyWindow{
		    position: fixed;
		    left: 0;
		    top: 0;
		    z-index: 999;
		    width: 100%;
		    height: 100%;
		    background-color: rgba(0,0,0,.3);
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: column;
		    justify-content: flex-end;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage {
		    width: 90%;
		    background-color: #fff;
		    border-radius: 5px;
		    margin-bottom: 30px;
		    position: relative;
		}
		.page .applyWindow .applyBtn {
		    width: 80%;
		    line-height: 45px;
		    color: #fff;
		    font-size: 16px;
		    border-radius: 12px;
		    text-align: center;
		    background-color: #0195ff;
		    margin-bottom: 14px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgTop {
		    width: 200px;
		    line-height: 35px;
		    text-align: center;
		    color: #fff;
		    font-size: 14px;
		    background-color: #0195ff;
		    margin: 0 auto;
		    border-radius: 12px;
		    border-top-left-radius: 0;
		    border-top-right-radius: 0;
		    margin-bottom: 28px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle {

		    padding-right: 20px;
		    padding-left: 20px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom {
		    padding: 15px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName , .input-area{
		    height: 60px;

		    border-bottom: 1px solid #e0e0e0;
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .birthday, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .city, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .dai-money, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .identityCardNumber, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber {
		    height: 60px;
		    width: 100%;
		    border-bottom: 1px solid #e0e0e0;
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName .userNameIcon, .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber .phoneNumberIcon, .shenfenzhengIcon {
		    width: 57px;
		    height: 100%;
		    display: flex;
		    display: -webkit-flex;
		    justify-content: center;
		    -webkit-justify-content: center;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName .userNameIcon .icon, .shenfenzhengIcon .icon {
		    width: 18px;
		    height: 20px;
		    background: url({{ asset('images/xuebitu.png') }}) no-repeat;
		    background-size: 180px 55px;
		    background-position: -95px 0;
		}

		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber .phoneNumberIcon .icon {
		    width: 14px;
		    height: 20px;
		    background: url({{ asset('images/xuebitu.png') }}) no-repeat;
		    background-size: 180px 55px;
		    background-position: -114px 0;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName .line {
		    height: 2px;
		    width: 1px;
		    background-color: #e0e0e0;
		}
		/*.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName input, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber input,*/
		.input-area input {
		    margin: 0;
		    border: 0;
		    color: #000;
		    line-height: 14px;
		    width: 100%;
		    padding: 10px 5px;
		    -webkit-user-select: text;
		    border-radius: 3px;
		    outline: 0;
		    background-color: #fff;
		    -webkit-appearance: none;
		    font-family: Helvetica Neue,Helvetica,sans-serif;
		    font-size: 14px;
		    -webkit-tap-highlight-color: transparent;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopDes p {
		    color: #aaa;
		    font-size: 12px;
		    line-height: 18px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol {
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		    -webkit-flex-direction: row;
		    align-items: center;
		    -webkit-align-items: center;
		    justify-content: flex-start;
		    -webkit-justify-content: flex-start;
		    color: #aaa;
		    font-size: 12px;
		}
		.agreeProtocolText{padding-left: 5px;}

		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .agreeProtocolIcon, .page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .disagreeProtocolIcon {
		    width: 16px;
		    height: 16px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .disagreeProtocolIcon {
		    background: url({{ asset('images/disagree.jpg') }}) no-repeat 0 0;
		    background-size: 16px 16px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .agreeProtocolIcon {
		    background: url({{ asset('images/agree.jpg') }}) no-repeat 0 0;
		    background-size: 16px 16px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .agreeProtocolText a {
		    color: #0195ff;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopTitle{
			margin-top: 10px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopTitle .title {
		    color: #0195ff;
		    font-size: 14px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopDes .p_one {
		    color: #e9232c;
		}

		.page .footer {
		    width: 100%;
		    height: 46px;
		    position: fixed;
		    left: 0;
		    bottom: 0;
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		}
		.page .footer .apply {
		    width: 100%;
		    height: 100%;
		    background-color: #ffa201;
		    text-align: center;
		    line-height: 46px;
		    color: #fff;
		    font-size: 14px;
		}
</style>