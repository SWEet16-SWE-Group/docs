import React, { Component } from 'react';
import axios from 'axios';

class ListRistoranti extends Component {
    state = {
      ristoranti: []
    }
    
    componentDidMount() {
      const url = 'http://localhost:8888/select_ristorante_1.php'
      axios.get(url).then(response =>
        this.setState({ ristoranti: response.data }));
    }

    render() {
        return (
            <div className="container-fluid">
             <div className="col-xs-8">
             <h1 className="mt-4 d-flex justify-content-center">SELECT</h1>
             <table className="table table-striped">
               <thead className="thead-light">
                <tr>
                 <th>Ragione Sociale</th>
                 <th>Indirizzo</th>
                 <th>CAP</th>
                 <th>Citta</th>
                 <th>Provincia</th>
                </tr>
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

export default ListRistoranti;