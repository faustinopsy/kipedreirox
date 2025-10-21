CREATE TABLE tbl_pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL, 
    valor_total DECIMAL(10, 2) NOT NULL,
    data_pedido TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status_pedido VARCHAR(50) NOT NULL DEFAULT 'Recebido'
);

CREATE TABLE tbl_pedido_itens (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL, 
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES tbl_pedidos(id_pedido)
);

CREATE TABLE tbl_produto (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    descricao_produto TEXT NULL,
    preco_produto DECIMAL(10, 2) NOT NULL,
    foto_produto VARCHAR(255) NULL,
    status_produto VARCHAR(50) NOT NULL DEFAULT 'Ativo',
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO tbl_produto (nome_produto, descricao_produto, preco_produto, foto_produto, status_produto) VALUES
('Tijolo Baiano 9 Furos', 'Tijolo cerâmico de alta qualidade para alvenaria e vedação.', 1.20, 'tijolo_baiano.jpg', 'Ativo'),
('Cimento Votoran Todas as Obras 50kg', 'Cimento Portland composto, ideal para rebocos, contrapisos e lajes.', 28.50, 'cimento_votoran.jpg', 'Ativo'),
('Areia Média Ensacada 20kg', 'Areia lavada de granulometria média, para produção de concreto e argamassa.', 5.80, 'areia_media.jpg', 'Ativo'),
('Argamassa ACIII Quartzolit 20kg', 'Argamassa colante para assentamento de cerâmicas em áreas internas e externas.', 22.90, 'argamassa_aciii.jpg', 'Ativo'),
('Tábua de Pinus 30cm x 3m', 'Tábua de madeira tratada para uso em caixarias e andaimes.', 35.00, 'tabua_pinus.jpg', 'Inativo'); -- Este não deve aparecer no site público