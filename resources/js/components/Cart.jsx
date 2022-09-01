import { useEffect, useState } from "react";

function Cart(){
    const [ products, setProducts ] = useState();
    const [ order, setOrder ] = useState();

    useEffect(() => {
        axios.get('/api/products')
        .then(resp => {
          setProducts(resp.data.products)
      });
    }, [setProducts])

    const scan = (code) =>{
        axios.post('/api/scan', {
            code
        })
        .then(() => {
            axios.get('/api/collect')
                .then(resp => {
                    setOrder(resp.data.order)
                }
            )
        })
    }

    const clearCart = () => {
        axios.post('/api/clear')
        .then(() => {
            axios.get('/api/collect')
                .then(resp => {
                    setOrder(resp.data.order)
                })
        })
    }

    useEffect(() => {
      axios.get('/api/collect')
      .then(resp => {
        setOrder(resp.data.order)
    });
    }, [setOrder])
    if(!order || !products){
        return <h3>Loading....</h3>
    }else{
        return(
            <div style={{display:"flex"}}>
                <div style={{width:"50%"}}>
                    <ul style={{listStyle:"none"}}>
                        {products.map((product, key) => {
                            return(
                                <li key={key}>{product.code} ---- $ {product.price} <button onClick={() => scan(product.code)}> SCAN  </button><br/><br/>
                                </li>

                            )
                        }) }
                    </ul>
                </div>
                <div style={{width:"50%"}}>
                    <h2>Cart:</h2>
                    <ul style={{listStyle:"none"}}>
                        {order && order.items && order.items.map((item, key) => {
                            return(
                                item.line_discount ?
                                <li key={key}>{item.quantity} x {item.code} ---- $ <s>{item.price * item.quantity}</s><span> ${item.line_price}</span><span style={{color:"red"}}> {item.bogo ? item.bogo : "pack discount"}</span> <br/><br/></li>
                                :
                                <li key={key}>{item.quantity} x {item.code} ---- $ {item.line_price}<br/><br/></li>
                            )
                        }) }
                    </ul>
                    {order.total &&
                        <>
                        <h2>Subtotal:: $ {order.total.subtotal}</h2>
                        <h4>Tax:: $ {order.total.tax}</h4>
                        <h2>Total::  $ {order.total.total}</h2>
                        <button style={{fontSize:"18px", padding:"10px", cursor:"pointer"}} onClick={clearCart}>Clear items</button>
                        </>
                    }
                </div>
            </div>
        )
    }
}

export default Cart;
