import React, { Component } from 'react'
import './Sale.css'
import Main from '../template/Main'

const headerProps = {
    icon: 'cart-plus',
    title: "Vendas",
    subtitle: 'Cadastros & Cia'
}

export default class Sale extends Component {

    render() {
        return (
            <Main {...headerProps}>
              Vendas
              
              {data}
            </Main>
        )
    }
}
if (document.getElementById('app')) {
    var data = document.getElementById('app').getAttribute('data');
}