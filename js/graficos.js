function grafico(dataPoints, colorArray, chartContainer, titulo, subtitulo, tipo, fontSize){
    CanvasJS.addColorSet("manifestacoesColors", colorArray);
	var chart = new CanvasJS.Chart(chartContainer, {
        colorSet: "manifestacoesColors",
		animationEnabled: true,
		exportEnabled: false,
		title:{
			text: titulo
		},
		subtitles: [{
			text: subtitulo
        }],
		data: [{
			type: tipo,
			showInLegend: "true",
            legendText: "{label}",
			indexLabelFontSize: fontSize,
			indexLabel: "{label} - #percent%",
            toolTipContent: "<b>{label}:</b> {y} (#percent%)",
			dataPoints: dataPoints
		}]
	});
chart.render();
}