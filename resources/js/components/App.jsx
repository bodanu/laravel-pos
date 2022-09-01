import ReactDOM from 'react-dom';
import { Sanctum } from "react-sanctum";
import Dashboard from './Dashboard';


const sanctumConfig = {
    apiUrl: "http://127.0.0.1:8000",
    csrfCookieRoute: "sanctum/csrf-cookie",
    signInRoute: "api/auth/login",
    signOutRoute: "api/auth/signout",
    userObjectRoute: "api/user",
  };

function App() {

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
