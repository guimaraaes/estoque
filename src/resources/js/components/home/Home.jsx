import React from 'react'
import Main from '../template/Main'
import Stat from './Stat'

export default props => {
    return (
        <Main icon="home" title="Início"
            subtitle="Sistema de Estoque">
            <div className="h4">Olá, Seja Bem Vindo ao Sistema de Estoque! Segue abaixo as suas estatísticas.</div>
            <hr />
            <div className="form">
                <div className="row">
                    <div className="col-12 col-md-4">
                        <Stat
                            color={{ color: "green" }}
                            title="Produtos"
                            icon="fa fa-barcode"
                            value={10}
                        >
                        </Stat>
                    </div>
                    <div className="col-12 col-md-4">
                        <Stat
                            title="Estoque Mínimo"
                            icon="fa fa-exclamation-triangle"
                            value={10}
                        >
                        </Stat>
                    </div>
                    <div className="col-12 col-md-4">
                        <Stat
                            color={{ color: "green" }}
                            title="Total de Vendas"
                            icon="fa fa-cart-plus"
                            value={10}
                        >
                        </Stat>
                    </div>
                </div>
                <div className="row">
                    <div className="col-12 col-md-4">
                        <Stat
                            color={{ color: "blue" }}
                            title="Usuários"
                            icon="fa fa-users"
                            value={10}
                        >
                        </Stat>
                    </div>
                </div>

            </div>
        </Main>
    )
}