import React from 'react';
import ReactDOM from 'react-dom';

class Currency extends React.Component {
    constructor(props) {
		super(props);
		this.state = {
			balance: balance
		}
    }

    render() {
        return (
            <div className="card">
                <div className="card-header">Currency Component</div>

                <div className="card-body">I'm an Currency component!</div>
            </div>
        );
    }
}

export default Currency;

if (document.getElementById('currency')) {
    ReactDOM.render(<Currency />, document.getElementById('currency'));
}
