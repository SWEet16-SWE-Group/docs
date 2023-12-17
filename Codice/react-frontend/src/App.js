import './App.css';

import Navbar from './components/navbar.js';
import ListRistoranti from './components/list_ristoranti.js';
import SignInCliente from './components/new_cliente.js';
import UpdateCliente from './components/edit_cliente.js';
import RemoveCliente from './components/remove_cliente.js';

function App() {
  return (
    <>
    <Navbar />
    <ListRistoranti />
    <SignInCliente />
    <UpdateCliente />
    <RemoveCliente />
    </>
  );
}

export default App;
