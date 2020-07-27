

CREATE TABLE usuario (
    id_usuario Integer,
    nome varchar(50),
    --senha
    PRIMARY KEY (id_usuario)
);

CREATE TABLE produto (
    id_produto Integer,
    nome varchar(50),
    quantidade Integer,
    quantidade_minima Integer,
    PRIMARY KEY (id_produto)
);

CREATE TABLE vendas (
    id_vendas Integer,
    id_produto Integer,
    id_usuario Integer,
    nome_cliente varchar(50),
    cpf_cliente varchar(50),
    quantidade_venda Integer,
    data_venda timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES produto (id_produto),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario),
    PRIMARY KEY (id_vendas)
);