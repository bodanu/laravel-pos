import React from 'react';
import { useEffect, useState } from "react";
import ReactDOM from 'react-dom';
import { Sanctum, useSanctum } from "react-sanctum";
import Dashboard from './Dashboard';


const sanctumConfig = {
    apiUrl: "http://127.0.0.1:8000",
    csrfCookieRoute: "sanctum/csrf-cookie",
    signInRoute: "api/auth/login",
    signOutRoute: "api/auth/signout",
    userObjectRoute: "api/user",
  };

function App() {
    const [users, setUsers] = useState();
    // useEffect(() => {
    //   axios.get('/users')
    //   .then(response => console.log(response.data));
    // //   axios.post('/api/auth/login', {
    // //     email: 'cashier@pos.com',
    // //     password: 'password'
    // //   })
    // //   .then(response => console.log(response.data));

    // }, [])

    return (
        <Sanctum config={sanctumConfig}>
           <Dashboard />
        </Sanctum>
    );
}

export default App;

if (document.getElementById('example')) {
    ReactDOM.render(<App />, document.getElementById('example'));
}
