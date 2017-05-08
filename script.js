var alleAfb = [
    'prisma.png'
];
var uitvoer = document.getElementById('uitvoer');
const TotaleBreedte = uitvoer.clientWidth;
var teller = 0;
var tijdelijkeBreedte = 0;
const UitgangsHoogte = 180;


function wisselArray(arr) {
    var nieuweArray = [];
    while (arr.length>0) {
        var rndm = Math.floor(Math.random()*arr.length);
        var element = arr.splice(rndm, 1);
        nieuweArray.push(element);
    }

    return nieuweArray;
}
alleAfb = wisselArray(alleAfb);

function maakRij() {
    var element = document.createElement('div');
    element.className = 'rij';
    uitvoer.appendChild(element);
}
function zoekDeRij(){
    var element = document.getElementsByClassName('rij');
    return element[0];
}


function maakPlaatje(num) {
    var afbeelding = document.createElement('img');
    afbeelding.src = 'img/' + alleAfb[num];
    afbeelding.alt = 'foto Drenthe ' + num;
    return afbeelding;
}

function nieuweHoogte(getal) {
    var gewensteHoogte = UitgangsHoogte*TotaleBreedte/getal;
    return gewensteHoogte + 'px';
}
function voegPlaatjeToe(num) {
    afb = maakPlaatje(num);
    var rij = zoekDeRij();
    rij.appendChild(afb);
    afb.addEventListener('load', function() {
        tijdelijkeBreedte =+ afb.clientWidth;
        if(tijdelijkeBreedte >= TotaleBreedte ) {
            rij.className = 'klaar';
            rij.style.height = nieuweHoogte(tijdelijkeBreedte);
            maakRij();
            tijdelijkeBreedte = 0;
        }
        teller ++;
        if(teller<alleAfb.length) {
            voegPlaatjeToe(teller);
        }
    });
}
maakRij();
voegPlaatjeToe(0);

document.getElementById('meer').addEventListener('click', function(){
    alleAfb = wisselArray(alleAfb);
    teller = 0;
    voegPlaatjeToe(0);
})



