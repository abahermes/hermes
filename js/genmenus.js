function genMenus(data,abauser){
	// console.log(data);
	var menus = data['rows'];
	var menu = "";
	var hasMenu = 0;
	if(abauser != ""){
		$("#mnuabaList").show();
		$("#mnuReq").show();
		$("#mnuMyAcct").show();
		$("#mnuUserLogin").hide();
		$("#abausername").html(abauser);

		for(var i=0; i<menus.length; i++){
			menu = menus[i]['menuid'];
			hasMenu = menus[i]['hasMenu'];
			// console.log(menu +' '+ hasMenu);
			switch(menu){
				case "ABVTGLOAPPRVL": case "SPFLDREQAPPRVL":
					if(hasMenu > 0){
						$("#mnuApprvl").show();

						switch(menu){
							case "ABVTGLOAPPRVL":
								$("#mnuAbvtApprvl").show(); break;
							case "SPFLDREQAPPRVL":
								$("#mnuSPFldApprvl").show(); break;
							default: break;
						}
					}
					break;
				case "ABACIMP": case "FXRATESIMP":
					if(hasMenu > 0){
						$("#mnuImport").show();

						switch(menu){
							case "ABACIMP":
								$("#mnuImpAbac").show(); break;
							case "FXRATESIMP":
								$("#mnuImpFXRates").show(); break;
							default: break;
						}
					}
					break;
				case "ABAGRPW":
					if(hasMenu > 0){
						$("#mnuabagrPW").show();
					}
					break;
				case "CDMRPTS": case "CMFRPTS": case "CMFBDRPTS": case "CMFCSRPTS":
					if(hasMenu > 0){
						$("#mnuRpts").show();

						switch(menu){
							case "CDMRPTS":
								$("#mnuCDMRpt").show(); break;
							case "CMFRPTS":
								$("#mnuCMFRpt").show(); break;
							case "CMFBDRPTS":
								$("#mnuCMFBDRpt").show(); break;
							case "CMFCSRPTS":
								$("#mnuCMFCSRpt").show(); break;
							default: break;
						}
					}
					break;
				case "SUP": case "ACCTS":
					if(hasMenu > 0){
						switch(menu){
							case "SUP":
								$("#mnuSupList").show(); break;
							case "ACCTS":
								$("#mnuDBCList").show(); break;
							default: break;
						}
					}
					break;
				case "ABVTLST": case "CATLST": case "ADMUSERS":
					if(hasMenu > 0){
						$("#mnuSettings").show();

						switch(menu){
							case "ABVTLST":
								$("#mnuAbvtList").show(); break;
							case "CATLST":
								$("#mnuAbvtCatList").show(); break;
							case "ADMUSERS":
								$("#mnuAdminUsers").show(); break;
							default: break;
						}
					}
					break;
					
				default: break;
			}
		}
	}else{
		$("#mnuUserLogin").show();
	}
}