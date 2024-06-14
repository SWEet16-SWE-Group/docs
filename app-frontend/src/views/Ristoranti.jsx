import {useEffect, useRef, useState} from "react";
import axiosClient from "../axios-client.js";
import RestaurantCard from "../components/RestaurantCard.jsx";

function ristorante(a){
  return <RestaurantCard restaurant={a} />;
  //return (
  //    <div key={a.id}>
  //      <Link to={`/ristorante/${a.id}`} key={a.id}> {a.nome} @ {a.indirizzo} # {a.telefono} | {a.orario} </Link>
  //    </div>
  //);
}

export default function Ristoranti() {
    const [ristoranti,setRistoranti] = useState(null);
    const [nome,setNome] = useState(null);
    const [cucina,setCucina] = useState('');

    function inputSet(set){
      return function (e) {
        set(e.target.value);
      };
    }

    function applicafiltri(){
      const a = ristoranti
        .filter(a => nome === null || a.nome.toLowerCase().includes(nome.toLowerCase()))
        .filter(a => cucina === "" || a.cucina === cucina)
        .map(ristorante);
      return a.length > 0 ? a : <p>Nessun risultato corrisponde ai criteri scelti</p>
    }

    function cucine(){
      function unique(value, index, array) {
        return array.indexOf(value) === index;
      };
      return ristoranti.map(a => a.cucina).filter(unique);
    }

    async function fetch(){
      const {data: data} = await axiosClient.get('/ristoranti');
      setRistoranti(data);
    }

    useEffect(() => { fetch(); }, []);

    return (
        <div>
            <div>
              <label htmlFor="nome">Nome</label>
              <input type="text" id="nome" onChange={inputSet(setNome)} />
            </div>
            <div>
              <label htmlFor="cucina">Cucina</label><br />
              {ristoranti
                ? (
                    <select id="cucina" onChange={inputSet(setCucina)}>
                      <option value={""}>Tutte le cucine</option>
                      {cucine().map(a => <option key={a} value={a}>{a}</option>)}
                    </select>
                  )
                : <p>Nessun tipo di cucina disponibile.</p>}
            </div>
            <hr className="my-4" />
            <div>
              {ristoranti ? applicafiltri() : <p>Caricamento...</p>}
            </div>
        </div>
    )
}
