<?php
include_once '../../inc/db.php';
include_once '../../inc/func.php';
$title = 'Крестики-нолики';
include_once '../../inc/head.php';

echo '<div class="news3"><div class="news">';
echo logos().'<br/><span class="vopros result" style="text-align: center;">Сыграем? Ваш ход!';
echo '</span><br/>';
echo '</div></div>';
?>
<style>
.krestiki_noliki{
    width: 250px;
    margin: 0 auto;
    overflow: hidden;
}
.krestiki_noliki .block{
    width: 80px;
    height: 80px;
    border: 1px solid #ccc;
    cursor: pointer;
    float: left;
    text-align: center;
    font-size: 80px;
    line-height: 80px;
    background: #fff;
}
</style>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
	
	var znak_user = 'O';
	var znak_comp = 'X';
	
	var rand_num = Math.round((Math.random() * (9 - 1) + 1));
	
	if( rand_num > 3 ){
		var znak_comp = 'O';
		var znak_user = 'X';
		document.querySelector('.cell'+rand_num).innerHTML = znak_comp;
	}
	
	var exit_flag = false;
	var win_pc = false;
	var win_user = false;
	var win_user_array = ['123','456','789','147','258','369','159','357'];
		
	function check_3_user(znak){
		for (var i = 0; i < 8; i++) {
		
			var first = 'cell' + win_user_array[i].substr(0,1);
			var second = 'cell' + win_user_array[i].substr(1,1);
			var third = 'cell' + win_user_array[i].substr(2,1);
			
			if(document.querySelector('.'+first).innerHTML == znak && document.querySelector('.'+second).innerHTML == znak && document.querySelector('.'+third).innerHTML == znak){
				document.querySelector('.'+first).setAttribute('style', 'background-color: #83e2c3;');
				document.querySelector('.'+second).setAttribute('style', 'background-color: #83e2c3;');				
				document.querySelector('.'+third).setAttribute('style', 'background-color: #83e2c3;');				
				unbind('.krestiki_noliki .block');
				exit_flag = true;
				win_user = true;
			}	
		}
	}
	
	function unbind(sel){
		var blocks = document.querySelectorAll(sel);
		for (var i = 0; i < blocks.length; i++) {
			blocks[i].innerHTML += " ";
		}
	}
	
	function check_2_comp(znak){
		for (var i = 0; i < 8; i++) {
		
			var first = 'cell' + win_user_array[i].substr(0,1);
			var second = 'cell' + win_user_array[i].substr(1,1);
			var third = 'cell' + win_user_array[i].substr(2,1);
			
			if( document.querySelector('.'+first).innerHTML == znak && document.querySelector('.'+second).innerHTML == znak && document.querySelector('.'+third).innerHTML == '' ){
				document.querySelector('.'+third).innerHTML = znak;
				document.querySelector('.'+first).setAttribute('style', 'background-color: #EF7C7C;');
				document.querySelector('.'+second).setAttribute('style', 'background-color: #EF7C7C;');				
				document.querySelector('.'+third).setAttribute('style', 'background-color: #EF7C7C;');		
				unbind('.krestiki_noliki .block');
				exit_flag = true;
				win_pc = true;
			}	
			
			if( document.querySelector('.'+first).innerHTML == znak && document.querySelector('.'+second).innerHTML == '' && document.querySelector('.'+third).innerHTML == znak ){
				document.querySelector('.'+second).innerHTML = znak;
				document.querySelector('.'+first).setAttribute('style', 'background-color: #EF7C7C;');
				document.querySelector('.'+second).setAttribute('style', 'background-color: #EF7C7C;');				
				document.querySelector('.'+third).setAttribute('style', 'background-color: #EF7C7C;');	
				unbind('.krestiki_noliki .block');
				exit_flag = true;
				win_pc = true;
			}	
			
			if( document.querySelector('.'+first).innerHTML == '' && document.querySelector('.'+second).innerHTML == znak && document.querySelector('.'+third).innerHTML == znak ){
				document.querySelector('.'+first).innerHTML = znak;
				document.querySelector('.'+first).setAttribute('style', 'background-color: #EF7C7C;');
				document.querySelector('.'+second).setAttribute('style', 'background-color: #EF7C7C;');				
				document.querySelector('.'+third).setAttribute('style', 'background-color: #EF7C7C;');	
				unbind('.krestiki_noliki .block');
				exit_flag = true;
				win_pc = true;
			}	
		}
	}
	
	function check_2_user(znak){

		for (var i = 0; i < 8; i++) {
		
			var first = 'cell' + win_user_array[i].substr(0,1);
			var second = 'cell' + win_user_array[i].substr(1,1);
			var third = 'cell' + win_user_array[i].substr(2,1);

			
			if( exit_flag == false ){
				if( document.querySelector('.'+first).innerHTML == znak && document.querySelector('.'+second).innerHTML == znak && document.querySelector('.'+third).innerHTML == '' ){
					document.querySelector('.'+third).innerHTML = znak_comp;
					exit_flag = true;
				}
			}
						
			if( exit_flag == false ){
				if( document.querySelector('.'+first).innerHTML == znak && document.querySelector('.'+second).innerHTML == '' && document.querySelector('.'+third).innerHTML == znak ){
					document.querySelector('.'+second).innerHTML = znak_comp;
					exit_flag = true;
				}	
			}	
			
			if( document.querySelector('.'+first).innerHTML == '' && document.querySelector('.'+second).innerHTML == znak && document.querySelector('.'+third).innerHTML == znak ){
				document.querySelector('.'+first).innerHTML = znak_comp;
				exit_flag = true;
			}
			
			if(exit_flag) break;
		}
	}
	
		
	function check_end(){
		if(exit_flag == true){
			if(win_pc == true){
				document.querySelector('.result').innerHTML = 'Вы проиграли!';
			}
			if(win_user == true){
				document.querySelector('.result').innerHTML = 'Вы выйграли!';
			}
			if(win_pc == true && win_user == true){
				document.querySelector('.result').innerHTML = 'Ничья!';
			}
		}
	}
	
	var blocks = document.querySelectorAll('.krestiki_noliki .block');
	for (var i = 0; i < blocks.length; i++) {
		blocks[i].addEventListener("click", function(event){
		//Если клетка пустая
			if(this.innerHTML == ''){
				this.innerHTML = znak_user;	
				check_3_user(znak_user);
				check_2_comp(znak_comp);
				check_2_user(znak_user);
				check_end();
				
				if( exit_flag == false ){
					for (var i = 1; i < 10; i++) {	
						if( document.querySelector('.cell'+i).innerHTML == '' ){
							document.querySelector('.cell'+i).innerHTML = znak_comp;
							break;
						}	
					}
				}else exit_flag = false;
				

			}
		});
	}
});
</script>
<div class="text">
<div class="krestiki_noliki">   
    <div class="block cell1"></div>
    <div class="block cell2"></div>
    <div class="block cell3"></div>
    <div class="block cell4"></div>
    <div class="block cell5"></div>
    <div class="block cell6"></div>
    <div class="block cell7"></div>
    <div class="block cell8"></div>
    <div class="block cell9"></div>    
</div>
</div>    
<?php
echo '<a class="menu" href="?"><img src="/style/ico/replay.png"/> Начать заново</a>';
include_once '../../inc/foot.php';
?>
