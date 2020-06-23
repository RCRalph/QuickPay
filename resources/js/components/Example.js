import React from 'react';
import ReactDOM from 'react-dom';

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faLongArrowAltRight } from "@fortawesome/fontawesome-free-solid";

class Currency extends React.Component {
    constructor(props) {
		super(props);
		this.state = {
			balance: balance
		}
    }

    render() {
        return (
			<div className="row">
				<div className="w-100 d-flex justify-content-between align-items-center mx-3 text-center">
					<div className="w-100">
						dsa
					</div>

					<div class="display-1 my-0 py-0 mx-4 text-primary">
						<FontAwesomeIcon icon={faLongArrowAltRight} />
					</div>

					<div className="w-100">
						sadsa
					</div>
				</div>
			</div>
        );
    }
}

export default Currency;

if (document.getElementById('currency')) {
    ReactDOM.render(<Currency />, document.getElementById('currency'));
}
