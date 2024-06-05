import {useParams} from "react-router-dom";
import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";

function fetch(id,set) {
  axiosClient.get(`/menu/${id}`).then(
    data => { set(data.data) }
  )
}

function pietanza(a){
  return (
    <div key={a.id}>
      <h1> {a.nome} </h1>
      <p> {a.ingredienti} </p>
    </div>
  );

}

export default function Ristorante() {
    const {id} = useParams();
    const [r,sr] = useState(null);
    useEffect(() => fetch(id,sr) ,[]);
    return (<div>{r && r.map(pietanza)}</div>)
}
