import './Nav.css'
import React from 'react'
import { Link } from 'react-router-dom'

export default props => {
  return (
    <aside className="menu-area">
      <nav className="menu">
        <Link to="/">
          <i className="fa fa-home"></i> Início
        </Link>
        <Link to="#">
          <i className="fa fa-users"></i>  Usuários
        </Link>
        <Link to="#">
          <i className="fa fa-list-alt"></i>  Clientes
        </Link>
        <Link to="/product">
          <i className="fa fa-barcode"></i>  Produtos
        </Link>
        <Link to="/sale">
          <i className="fa fa-cart-plus"></i>  Vendas
        </Link>
        <Link to="#">
          <i className="fa fa-file-text"></i>  Relatórios
        </Link>
      </nav>
    </aside>
  )
}
