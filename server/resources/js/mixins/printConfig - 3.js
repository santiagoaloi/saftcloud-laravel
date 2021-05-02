// import axios from 'axios'
// import { store } from '@/store'

export default {
	name: 'printConfig',
	data() {
		return {
			testArray: ['val1', 'val2', 'val3'],
			testBoolean: false,
			testObject: {
				key: 'value1',
				key2: 'value2'
			},
			testNumber: 0,
			testStrong: 'string',

			cssText: `
				.content{
				width:100%;
				padding: 0px;
				margin:0px;
				font-size: 13px;
				
				}
				.divider{
				border: 0.01em black solid;
				}
				.header{
				
				}
				.logo{
				text-align: left;
				}
				.budgetNro{
				text-align: left;
				}
				.copmanyDetails{
				text-align: center;
				}
			
				.clientDetails{
				text-align: left;
				}
			
				.budgetDetails{
				text-align: left;
				}
			
				.detalle{
				font-weight: bold;
				}
			
				.precio{
				text-align: right;
				font-style: oblique;
				font-size: 1em;
				font-weight: bold;
				}
				.firma{
				width:15%;
				float:right;
				text-align: center;
				}
				.dividerFirma{
				margin-top:50px;
				}
				.footer{
				text-align: center;
				color: #000000;
				font-size: 1em;
				font-weight: bold;
				}
		  	`,

		  	cssInvoice:`
				.content{
					width:90%;
					height:1000px;
					padding: 0px;
					margin: 2.5% 5% 2.5% 5%;
					font-size: 1em;
					font-family: 'Roboto Mono', monospace;
					line-height: 1;
				}
				.header{
					height:12%;
					margin-top:2.5%;
					width: 100%;
				}
				.logo{
					width: 32%;
					text-align: left;
					float: left;
					margin-left:1%;
				}
				.budgetNro{
					height:100%;
					width: 33%;
					float: left;
					font-size: 2em;
					font-weight: bold;
					text-align:center;
				}
				.budgetLetter{
					height:40%;
					margin:0px auto;
					margin-top:-7.5%;
					text-align:center;
					width:30%;
					padding-bottom:2.5%;
					border-left: 2px solid black;
					border-right: 2px solid black;
					border-bottom: 2px solid black;
				}
				.budgetLine{
					height:75%;
					width:50%;
					border-right: 2px solid black;
				}
				.copmanyDetails{
					width: 32%;
					text-align: right;
					float: left;
					margin-right:1%;
				}
				.clientDetails{
					width: 100%;
					text-align: left;
				}
				.budgetDetails{
					margin-top: 2.5%;
					text-align: left;
				}
				.detalle{
					margin-top: 2.5%;
					width: 100%;
					text-align: center;
				}
				.precio{
					text-align: right;
					font-style: oblique;
					font-size: 1.5em;
					font-weight: bold;
					margin-right: 5%;
					margin-top: 5%;
				}
					.footer{
					margin-top: 10%;
					text-align: left;
					font-size: 1em;
					width: 100%;
				}
				.firmaFooter{
					width:100%;
					float:left;
					margin-top: 5%;
					text-align: center;
				}
				.firma{
					width:10%;
					float:right;
					margin-right: 15%;
				}
				.dividerFirma{
					margin-top:50px;
				}
				.cae{
					float:left;
					margin-top: 5%;
					text-align: left;
					font-size: 1em;
					width: 100%;
				}
		  	`,

		  	serviveOrder: `
				.content{
					width:100%;
					padding: 0px;
					font-size: 1,2em;
					color: #000000;
					font-family: sans-serif;
				}
				.divider{
					border: 1px solid black;
				}
				.header{
					margin: 7% 5% 2.5% 5%;
					width:90%;
					height: 75px;
					padding: 0px;
				}
				.logo{
					width:35%;
					float:left;
					text-align: center;
				}
				.budgetNro{
					width:30%;
					float:left;
					text-align: center;
				}
				.copmanyDetails{
					width:35%;
					float:left;
					text-align: center;
				}

				.clientDetails{
					margin: 2% 5% 2.5% 5%;
					width:90%;
					float:left;
					text-align: left;
				}
				.clientDetailsSubtitles{
					width:100%;
					float:left;
				}
				.budgetDetails{
					width:50%;
					float:left;
				}

				.detalle{
					margin: 2% 5% 0% 5%;
					width: 90%;
					text-align: left;
					font-weight: bold;
					font-style: oblique;
					float: left;
				}

				.precio{
					width: 90%;
					margin: 2% 5% 0% 5%;
					text-align: right;
					float: right;
					color: #000000;
					font-family: sans-serif;
					font-size: 1.5em;
					font-weight: bold;
				}
				.firma{
					margin: 5% 5% 0% 5%;
					width:15%;
					float:right;
					text-align: center;
				}
				.dividerFirma{
					margin-top:50px;
				}
				.footer{
					width: 90%;
					text-align: center;
					color: #000000;
					font-family: sans-serif;
					font-size: 1em;
					font-weight: bold;
					float: left;
					margin: 10% 5% 0% 5%;
				}
		  	`,
		}
	},

	mounted() {
		console.log('Mounted from printConfig.js working!')
	},

	methods: {
		testMethod() {
			console.log('Test method working!')
		}
	},

	computed: {

		testComputed() {
			return 'TestComputedValue'
		}
	}

}
