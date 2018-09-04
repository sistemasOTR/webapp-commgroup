$(document).ready(function(){                
	$("#mnu_sueldos").addClass("active");
});
$(document).ready(function(){                
	$("#mnu_legajos_remun").addClass("active");
});

function add_fields() {
	ind = document.getElementById('cant_totales').value;
	ind++;
	var objTo = document.getElementById('form_conceptos')
	var divtest = document.createElement("div");
	divtest.innerHTML = '<div class="col-md-4"><input type="text" name="concepto_'+ind+'" id="concepto_'+ind+'" class="form-control"></div><div class="col-md-1"><input type="text" value="1" name="unidades_'+ind+'" id="unidades_'+ind+'" class="form-control"><input type="hidden" value="1" name="base_'+ind+'" id="base_'+ind+'" class="form-control base"></div><div class="col-md-1"><h6></h6></div><div class="col-md-2"><input type="number" name="remu_'+ind+'" id="remu_'+ind+'" value="0" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01"></div><div class="col-md-2"><input type="number"  name="desc_'+ind+'" id="desc_'+ind+'" class="form-control descuento" value="0" onchange="actualizaTotalDesc()" step="0.01"></div><div class="col-md-2"><input type="number"  name="no_remu_'+ind+'" id="no_remu_'+ind+'" class="form-control" value="0" onchange="actualizaTotalNR()" step="0.01"></div>';

	objTo.appendChild(divtest);
	document.getElementById('cant_totales').value = ind;

}

function actualizaTotal(){
	cant = document.getElementById('cant_totales').value;
	total = 0;
	console.log(cant);

	for (var i = 1; i <= cant; i++) {
		console.log(document.getElementById('remu_'+i).value);
		total = Number(total) + Number(document.getElementById('remu_'+i).value);
	}

	document.getElementById('remu_totales').value = parseFloat(total).toFixed(2);

	totalDesc = 0;

	for (var j = 9; j <= 13; j++) {
		document.getElementById('desc_'+j).value = parseFloat(Number(total) * Number(document.getElementById('unidades_'+j).value) / Number(document.getElementById('base_'+j).value)).toFixed(2);

	}

	for (var j = 1; j <= cant; j++) {
		totalDesc = Number(totalDesc) + Number(document.getElementById('desc_'+j).value);

	}

	document.getElementById('desc_totales').value = parseFloat(totalDesc).toFixed(2);

}

function actualizaTotalNR(){
	cant = document.getElementById('cant_totales').value;
	total = 0;

	for (var i = 1; i <= cant; i++) {
		total = Number(total) + Number(document.getElementById('no_remu_'+i).value);
	}

	document.getElementById('no_remu_totales').value = parseFloat(total).toFixed(2);

}

function  actualizaTotalDesc(){
	cant = document.getElementById('cant_totales').value;
	total = 0;

	for (var i = 1; i <= cant; i++) {
		total = Number(total) + Number(document.getElementById('desc_'+i).value);
	}

	document.getElementById('desc_totales').value = parseFloat(total).toFixed(2);

}

function changeUnidades() {
	cant = document.getElementById('cant_totales').value;
	var unidades=[], remu=[], desc=[], no_remu=[],base=[];

	basico = document.getElementById('basico').value;
	jornada = document.getElementById('jornada').value;

	for (var i = 1; i <= cant; i++) {
		unidades[i] = document.getElementById('unidades_'+i).value;
		base[i] = document.getElementById('base_'+i).value;
		remu[i] = document.getElementById('remu_'+i).value;
		desc[i] = document.getElementById('desc_'+i).value;
		no_remu[i] = document.getElementById('no_remu_'+i).value;
		}

		remu[1] = Number(unidades[1]) * Number(basico) * Number(jornada) / Number(base[1]);
		remu[2] = Number(unidades[2]) * Number(basico) * Number(jornada) / Number(base[2]);
		remu[3] = Number(unidades[3]) * Number(basico) * Number(jornada) / Number(base[3]);
		remu[4] = 0;
		remu[5] = (Number(remu[1])+Number(remu[2])+Number(remu[3])+Number(remu[4]))*Number(unidades[5])/Number(base[5]);
		remu[6] = (Number(remu[1])+Number(remu[2])+Number(remu[3])+Number(remu[4])+Number(remu[5]))*Number(unidades[6])/Number(base[6]);
		remu[7] = Number(unidades[7])*Number(base[7]);

		total = 0;

		for (var i = 1; i <= cant; i++) {
			total = Number(total) + Number(remu[i]);
		}

		totalDesc = 0;

		for (var j = 9; j <= 13; j++) {
			desc[j] = Number(total) * Number(unidades[j]) / Number(base[j]);

		}

		for (var j = 1; j <= cant; j++) {
			totalDesc = Number(totalDesc) + Number(desc[j]);

		}


	for (var j = 1; j <= cant; j++) {
		document.getElementById('remu_'+j).value = parseFloat(remu[j]).toFixed(2);
		document.getElementById('desc_'+j).value = parseFloat(desc[j]).toFixed(2);
		document.getElementById('no_remu_'+j).value = parseFloat(no_remu[j]).toFixed(2);
	}
		document.getElementById('desc_totales').value = parseFloat(totalDesc).toFixed(2);
		document.getElementById('remu_totales').value = parseFloat(total).toFixed(2);
}