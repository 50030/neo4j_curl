

return ;

$(function(){
	cytoscape({
		container: document.getElementById('cy'),
		style: [
			{
				selector: 'node[label = "中国科学院计算机研究所"]',
				css: {'background-color': '#6fb1fc', 'content': 'data(name)'}
			},
			{
				selector: 'node[label = "line"]',
				css: {'background-color': '#6fb1fc', 'content': 'data(name)'}
			},
			/*{
				selector: 'line',
				css: {'background-color': '#6fb1fc', 'content': 'data(name)'}
			},*/
			{
				selectot: 'node[label="school"]',
				css: {'background-color': '#f5a45d', 'content': 'data(title)'}
			},
			{
				selector: 'edge',
				//css: {'content': 'data(relationship)', 'target-arrow-shape': 'triangle'}
				css: {'curve-style': 'bezier','target-arrow-shape': 'triangle','line-color': '#ffaaaa','target-arrow-color': '#ffaaaa','content': 'data(relationship)'}
			}
		],
		
		elements: {
			nodes: [
				/*{data: {id: '2', name:'徐志伟', label: '中国科学院计算机研究所'}},
				{data: {id: '5', name:'文继荣', label: '中国科学院计算机研究所'}},
				{data: {id: '6', name:'文继荣2', label: '中国科学院计算机研究所'}},
				{data: {id: '7', name:'郑爱军', label: '中国科学院计算机研究所'}},
				{data: {id: '8', name:'郑伊然', label: '中国科学院计算机研究所'}},
				{data: {id: '1001', name:'school', label: '中国科学院计算机研究所'}}*/
				{data: {id: '7', name:'郑爱军', label: 'line'}},
				{data: {id: '7', name:'郑爱军', label: 'line'}},
				{data: {id: '7', name:'郑爱军', label: 'line'}},
				{data: {id: '7', name:'郑爱军', label: 'line'}},
				
				
				{data: {id: '9', name:'郑本荣', label: 'line'}},
				{data: {id: '10', name:'郑爱民', label: 'line'}},
				{data: {id: '11', name:'郑爱群', label: 'line'}},
				{data: {id: '12', name:'刘慧捷', label: 'line'}},
				{data: {id: '13', name:'彭燕梅', label: 'line'}},
				
				
				{data: {id: '8', name:'郑伊然', label: 'line'}}
			],
			
			edges: [
				/*{data: {source: '2', target: '1001', relationship: 'belong_to'}},
				{data: {source: '6', target: '1001', relationship: 'belong_to'}},
				{data: {source: '5', target: '1001', relationship: 'belong_to'}},*/
				{data: {source: '7', target: '9', relationship: '有父亲'}},
				{data: {source: '9', target: '7', relationship: '有儿子'}},
				{data: {source: '8', target: '7', relationship: '有父亲'}},
				
				{data: {source: '10', target: '9', relationship: '有父亲'}},
				{data: {source: '11', target: '9', relationship: '有父亲'}},
				{data: {source: '9', target: '10', relationship: '有儿子'}},
				{data: {source: '9', target: '11', relationship: '有儿子'}},
				
				{data: {source: '7', target: '12', relationship: '有母亲'}},
				{data: {source: '12', target: '7', relationship: '有儿子'}},
				
				{data: {source: '7', target: '13', relationship: '有妻子'}},
				{data: {source: '13', target: '7', relationship: '有丈夫'}},
				
				{data: {source: '8', target: '13', relationship: '有母亲'}},
				{data: {source: '13', target: '8', relationship: '有女儿'}},
				
				{data: {source: '7', target: '8', relationship: '有女儿'}}
				
				
			]
		},
		
		layout: {name: 'grid'}
	});
});