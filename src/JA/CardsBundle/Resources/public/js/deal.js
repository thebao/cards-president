function newdeck(){
	var suits = ["&hearts;", "&spades;", "&clubs;", "&diams;"];
	var faces = ["J","Q","K"];
	var faces_val = ["11","12","13"];
	var deck = [];
	var joker = "JOKER";
	for (i=0;i<4;i++){
		for (j=1;j<14;j++){
			deck.push(i.toString()+j.toString());
		}/*
		deck.push(suits[i]+"j");
		deck.push(suits[i]+"q");
		deck.push(suits[i]+"k");*/
	}
	suitPositions = [
		"0000000000000001",
		"0000010001000000",
		"0000010101000000",
		"1000100000100010",
		"1000100100100010",
		"1010100000101010",
		"1010101000101010",
		"1010101010101010",
		"1101100100110110",
		"1101101010110110"
	];
	spots=["spotA1","spotA2","spotA3","spotA4","spotA5","spotB1","spotB2","spotB3","spotB4","spotB5","spotC1","spotC2","spotC3","spotC4","spotC5","ace"];
	deck.push("jk1");
	deck.push("jk2");
	var shuffled = shuffle(deck.slice(0));
	//console.log(deck);
	//console.log(shuffled);

	for (i=0;i<shuffled.length;i++){
		card = shuffled[i];
		color="black-card"
		if (card != "jk1" && card != "jk2"){
			suit = suits[card.substring(0,1)];
			num = card.substring(1);
			if (suit=="&hearts;" || suit =="&diams;")
				color="red-card";
			
			//console.log(num);
			if (num<11){
				val=num;
				if (num==1)
					val=14;
				vizCard = "<div class='card "+color+"' data-val='"+val+"' data-name='"+num+suit+"' data-state='off' data-potential='yes'>"+
							"<div class='card-back'></div>"+
							"<div class='main'>";
				for(j=0;j<spots.length;j++){
					if (suitPositions[num-1].substring(j,j+1)==1){
						inst = suit;			
						vizCard+="<div class='"+spots[j]+"'>"+inst+"</div>";
					}
				}
				vizCard+="</div>"+
							"<div class='top-left'>"+
								"<div class=''>"+num+"</div>"+
								"<div class='sm-suit'>"+suit+"</div>"+
							"</div>"+
							"<div class='bottom-right'>"+
								"<div class=''>"+num+"</div>"+
								"<div class='sm-suit'>"+suit+"</div>"+
							"</div>"+
						"</div>";
						
			}
			if (num>10){
				vizCard = "<div class='card "+color+"'  data-val='"+num+"' data-name='"+faces[num-11]+suit+"'  data-state='off' data-potential='yes'>"+
							"<div class='card-back'></div>"+
							"<div class='main face'>";
				vizCard +="<img src='img/faces/"+card+".png'>";			
				vizCard+="</div>"+
							"<div class='top-left'>"+
								"<div class='condense'>"+faces[num-11]+"</div>"+
								"<div class='sm-suit'>"+suit+"</div>"+
							"</div>"+
							"<div class='bottom-right'>"+
								"<div class='condense'>"+faces[num-11]+"</div>"+
								"<div class='sm-suit'>"+suit+"</div>"+
							"</div>"+
						"</div>";
				
			}
			
		}
		else{
			vizCard = "<div class='card "+color+"' data-val='15' data-name='jk' data-state='off' data-potential='yes'>"+
							"<div class='card-back'></div>"+
								"<div class='main face'>";
					vizCard +="<img src='img/faces/jk.png'>";			
					vizCard+="</div>"+
							"<div class='top-left'>"+
								"<div class='joker condense'>"+joker+"</div>"+
							"</div>"+
							"<div class='bottom-right'>"+
								"<div class='joker condense '>"+joker+"</div>"+
							"</div>"+
							"</div>";
		}
		if(i%4==0)
			$("#north").delay(800).append(vizCard);
		else if (i%4==1)
			$("#east").delay(800).append(vizCard);
		else if (i%4==2)
			$("#south").append(vizCard);
		else if (i%4==3)
			$("#west").delay(800).append(vizCard);

	}
	
	juststack();
	justflip("north");
	justflip("west");
	justflip("east");
}