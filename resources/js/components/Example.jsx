import React from 'react';
import { useEffect, useState } from "react";
import ReactDOM from 'react-dom';

function Example() {
    const [users, setUsers] = useState();
    useEffect(() => {
      axios.get('/users')
      .then(response => console.log(response.data));

    }, [])

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Example Component</div>

                        <div className="card-body">I'm an example component!</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Example;

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
