import React, { useState } from "react";
import { Row, Col, Card, Button } from "react-bootstrap";
import { Link, useLocation } from "react-router-dom";
import { RechercheReq, TableData, FormSerch } from "../request/Request";

const InfoCasier = () =>{
    const location = useLocation();

    const param = new URLSearchParams(location.search);
    const code = param.get('c');
    const nom = param.get('name');
    
    return (
        <>
            <div className="text-center mb-5 fade-in-box">
                <h1 className="fw-bold">Information sur casier {nom}</h1>
                <p className="text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nesciunt, tenetur nobis. Iusto perferendis asperiores nihil laborum, expedita voluptatem dicta suscipit, illo reiciendis labore iure.</p>
            </div>
            <Row className="justify-content-around fade-in-box">
                <TableData
                    url={"/get_byCodecasier"}
                    code={code}
                    renderRow={(casier, index) => (
                        <>
                            <Col md={10}>
                                <Card key={index} className="d-flex flex-row justify-content-around m-0 mb-3 pt-0">
                                    <Card.Body>
                                        <Card.Text className="py-0 my-0"><span>Nom :</span> <span className="fw-bold">{casier.nom}</span></Card.Text>
                                        <Card.Text className="py-0 my-0"><span>Postnom :</span> <span className="fw-bold">{casier.postnom}</span></Card.Text>
                                        <Card.Text className="py-0 my-0"><span>Prénom :</span> <span className="fw-bold">{casier.prenom}</span></Card.Text>
                                        <Card.Text className="py-0 my-0"><span>Numéro Identité :</span> <span className="fw-bold">{casier.num_identite}</span></Card.Text>
                                        <Card.Text className="py-0 my-0"><span>code de vérification :</span> <span className="fw-bold">{casier.code}</span></Card.Text>
                                        <Card.Text className="py-0 my-0"><span>Sexe :</span> <span className="fw-bold">{casier.sexe}</span></Card.Text>
                                        <Card.Text className="py-0 my-0"><span>Nationalité :</span> <span className="fw-bold">{casier.nationalite}</span></Card.Text>
                                        <Card.Text className="py-0 my-0"><span>Statut du casier :</span> <span className="fw-bold">{casier.statut}</span></Card.Text>
                                    </Card.Body>
                                    <Card.Header className="text-center">
                                        <Card.Img src={casier.img} className="img-fluid img-casier rounded-bottom-0" />
                                    </Card.Header>
                                </Card>
                                <Row className="my-3">
                                    <Button as={Link} className="rounded-4 text-white fw-bolder text-uppercase" to={'/infraction?code='+casier.code_casier+'&name='+casier.nom+' '+casier.prenom} variant="warning">Ajouter / Voir infraction</Button>
                                </Row>
                            </Col>
                        </>
                    )}
                />
            </Row>
        </>
    )
}



export const Identification = ({onScanSuccess}) => {
    const [search, setSearch] = useState("");
    return (
        <>
            <div className="text-center mb-5 fade-in-box">
                <h1 className="fw-bold">Information sur casier</h1>
                <p className="text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nesciunt, tenetur nobis. Iusto perferendis asperiores nihil laborum, expedita voluptatem dicta suscipit, illo reiciendis labore iure.</p>
            </div>

            <Row className="justify-content-center my-3 fade-in-box">
                <FormSerch search={search} setSearch={setSearch} classSerch={"my-2 col-md-5"} />
                <Col className="row ms-2 justify-content-center bg-white border" lg="12" id="debut">
                    {
                    search.trim() === "" ?
                    
                    <TableData
                        url="/get_infraction"
                        typeReturn="Table"
                        headerItem={['N°', 'Nom & Postnom', 'Prénom', 'Status du casier', 'Action']}
                        renderRow={(infraction, index) => (
                            <tr key={index}>
                                <td>{infraction.id}</td>
                                <td>{infraction.nom} {infraction.postnom}</td>
                                <td>{infraction.prenom}</td>
                                <td>{infraction.statut}</td>
                                <td><Button as={Link} to={'/infraction?code='+infraction.code+'&name='+infraction.nom+' '+infraction.prenom} variant="warning" title={infraction.code} size="sm">Voir plus</Button></td>
                            </tr>
                        )}
                    /> :

                    <RechercheReq
                        url={"/search_infraction"}
                        search={search}
                        headerItem={['N°', 'Nom & Postnom', 'Prénom', 'Status du casier', 'Action']}
                        renderRow={(infraction, index) => (
                            <tr key={index}>
                                <td>{infraction.id}</td>
                                <td>{infraction.nom} {infraction.postnom}</td>
                                <td>{infraction.prenom}</td>
                                <td>{infraction.statut}</td>
                                <td><Button as={Link} to={'/infraction?code='+infraction.code+'&name='+infraction.nom+' '+infraction.prenom} variant="warning" title={infraction.code} size="sm">Voir plus</Button></td>
                            </tr>
                        )}

                    />
                    }  
                </Col>
            </Row>
        </>
    )
}

export default InfoCasier;