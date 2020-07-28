import 'bootstrap/dist/css/bootstrap.css';
import React from 'react';

import './App.css';
import { BrowserRouter } from 'react-router-dom'

import Routes from './Routes'
import Logo from './template/Logo'
import Nav from './template/Nav'
import Footer from './template/Footer'

function App() {
    return (
        <BrowserRouter>
            <div className="app" >
                <Logo />
                <Nav />
                <Routes />
                <Footer />
            </div >
        </BrowserRouter>
    );
}

export default App;


