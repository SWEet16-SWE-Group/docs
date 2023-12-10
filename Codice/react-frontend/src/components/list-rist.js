import React, { Component } from 'react';
import axios from 'axios';

class ListRist extends Component {
    state = {
      ristoranti: []
    }
    componentDidMount() {
      const url = 'http://localhost:8888/q_ristorante_1.php'
      axios.get(url).then(response =>
        this.setState({ ristoranti: response.data }));
    }
    render() {
        return (
            <div className="container">
             <div className="col-xs-8">
             <h1>Lista Ristoranti</h1>
             <table className="table table-striped">
               <thead className="thead-light">
                 <th>Ragione Sociale</th>
                 <th>Indirizzo</th>
                 <th>CAP</th>
                 <th>Citta</th>
                 <th>Provincia</th>
               </thead>
               <tbody>
               {this.state.ristoranti.map((rs, index) => (
                 <tr key={index}>
                   <td>{rs.Ragione_sociale}</td>
                   <td>{rs.Indirizzo}</td>
                   <td>{rs.CAP}</td>
                   <td>{rs.Citta}</td>
                   <td>{rs.Provincia}</td>
                 </tr>
                 ))}
               </tbody>
             </table>
             </div>
            </div>
         );
       }
     }

export default ListRist;