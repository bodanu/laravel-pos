import { useEffect, useState } from "react";


function Discounts() {
    const [ discounts, setDiscounts ] = useState();
    const [ type, setType ] = useState('pack');
    const [ code, setCode ] = useState('');
    const [ quantity, setQuantity ] = useState('');
    const [ price, setPrice ] = useState('');
    const [ bogoItem, setBogoItem ] = useState('');

    useEffect(() => {
        axios.get('/api/discounts')
        .then(resp => {
          setDiscounts(resp.data.discounts)
      });
    }, [setDiscounts])

    const editOrCreateDiscount = () => {
        axios.post('/api/discounts/set', {
            'type': type,
            'code': code,
            'quantity': quantity,
            'price':price,
            'bogo_item': bogoItem
        })
        .then(() => {
            axios.get('/api/discounts')
                .then(resp => {
                setDiscounts(resp.data.discounts)
            });
        }
        )
    }
    console.log(type)

    return(
            !discounts
            ?
                <h3>No discounts available</h3>
            :
            <div>
                <h2>Available discounts:</h2>
                <ul>
                    {discounts.map((discount, key) => {
                        if(discount.type == 'bogo'){
                            return (
                                <li key={key}>Buy one {discount.applies_to} and get one {discount.bogo_gets} for free!</li>
                            )
                        }else{
                            return (
                                <li key={key}>Buy {discount.pack_size} pieces of {discount.applies_to} for only  $ {discount.pack_value}</li>
                            )
                        }
                    })}
                </ul>
                <div style={{display:"flex", width:"40%", flexDirection:'column'}}>
                    <label htmlFor="type">Discount type. Available: "pack" , "bogo"</label>
                    <input type="text" name='type' value={type} onChange={(e) => setType(e.target.value)} />
                    <label htmlFor="code">Product code to apply rule</label>
                    <input type="text" name='code' value={code} onChange={(e) => setCode(e.target.value)} />
                    <label htmlFor="quantity">*for pack discounts only. Product pack size</label>
                    <input type="number" name="quantity" value={quantity} onChange={(e) => setQuantity(e.target.value)} />
                    <label htmlFor="price">*for pack discounts only. Product pack price</label>
                    <input type="number" name="price" value={price} onChange={(e) => setPrice(e.target.value)} />
                    <label htmlFor="bogoItem">*for bogo discounts only. Product to receive for free</label>
                    <input type="text" name="bogoItem" value={bogoItem} onChange={(e) => setBogoItem(e.target.value)} />
                </div>
                    <button onClick={editOrCreateDiscount}>Submit</button>
            </div>
    )
}

export default Discounts;
