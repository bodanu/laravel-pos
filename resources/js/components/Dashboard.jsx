import { useSanctum } from "react-sanctum";
import Cart from './Cart';

function Dashboard(){
    const { authenticated, user, signIn, signOut } = useSanctum();

    const closeTerminal = () => {
        signOut();
    }


    const handleLogin = () => {
        const email = "cashier@pos.com";
        const password = "password";
        const remember = true;

        signIn(email, password, remember)
      };

    if(authenticated == null){
        return (
            <div style={{display:"flex", justifyContent:"center", alignItems:"center", height:"100vh"}}>
                <h3>Loading....</h3>
            </div>
        )
    }
    if(authenticated == false){
        return(
            <div style={{display:"flex", justifyContent:"center", alignItems:"center", height:"100vh"}}>
                <button style={{fontSize:"34px", padding:"20px", cursor:"pointer"}} onClick={handleLogin}>Start terminal</button>
            </div>
        )

    }

    if (user) {
        return(
            <div style={{display:"flex", flexDirection:"column"}}>
                <h1 style={{textAlign:"center"}}>Welcome, {user.name}</h1>
                <Cart />
                <hr/>
                <button style={{fontSize:"18px", padding:"12px", cursor:"pointer", alignSelf:"center", marginTop:"150px"}} onClick={closeTerminal}>Close terminal</button>
            </div>
        )
    }
  }

  export default Dashboard
