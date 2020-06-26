import React from 'react';

function Block(props) {
	return (
		<div className="w-100 row">
			<div className="col-lg-7">
				<input type="number" step="0.01" id={props.id} className="form-control" placeholder={props.placeholder} value={props.currentValue} onChange={props.handleValues} />
			</div>

			<div className="col-lg-4 ml-auto">
				<select
					id={props.currencyID}
					className="form-control"
					value={props.currencyValue}
					onChange={props.handleCurrencies}
				>
					{props.currencies.map(item => {
						return (
							props.currencyID == "currenciesLeft" ?
							<option key={item.id} value={item.id}>{item.ISO_4217}</option> :
							item.id != props.currencyLeft && <option key={item.id} value={item.id}>{item.ISO_4217}</option>
						)
					})}
				</select>
			</div>
		</div>
	)
}

export default Block;
