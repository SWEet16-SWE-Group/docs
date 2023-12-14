import './App.css';

import Navbar from './components/navbar.js';
import ListRistoranti from './components/list_ristoranti.js';
import SignInCliente from './components/new_cliente.js';
import ClientUpdate from './components/edit_cliente.js';

function App() {
  return (
    <>
    <Navbar />
    <ListRistoranti />
    <SignInCliente />
    <ClientUpdate />
    </>
  );
}

export default App;
