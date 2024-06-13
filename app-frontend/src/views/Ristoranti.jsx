import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";

function ristorante(a){
  return (
      <div key={a.id}>
        <Link to={`/ristorante/${a.id}`} key={a.id}> {a.nome} @ {a.indirizzo} # {a.telefono} | {a.orario} </Link>
      </div>
  );
}

export default function Ristoranti() {
    const [ristorantiTutti,setRistorantiTutti] = useState(null);
    const [ristoranti,setRistoranti] = useState(null);
    const [nome,setNome] = useState(null);
    const [cucina,setCucina] = useState(null);
    const [orario,setOrario] = useState(null);

    function applicafiltri(){
      setRistoranti(
         ristorantiTutti
          //.filter((r) => r.nome.contains(nome) && (cucina === null || r.cucina === cucina))
      );
      debugger;
    }

    async function fetch(){
      const {data: data} = await axiosClient.get('/ristoranti');
      setRistorantiTutti(data);
      applicafiltri();
    }

    useEffect(() => { fetch(); }, []);

    console.log('========================');
    console.log(ristorantiTutti);
    console.log(ristoranti);
    console.log('------------------------');

    return (
        <div>
            {ristoranti ? ristoranti.map(ristorante) : <div>Nessun ristorante corrisponde ai filtri scelti</div>}
        </div>
    )
}
