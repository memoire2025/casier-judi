import { useState } from "react";
import { Row, Col, Button } from "react-bootstrap";
import { TableData, DataForm, RechercheReq, AlertInfo, FormSerch } from "../request/Request";
import { Link, useNavigate } from "react-router-dom";

export default function Agent () {
    const defautInputClass = "shadow-none rounded";
    const classFormGroup = "my-2 col-md-11";
    const navigate = useNavigate();

    const [search, setSearch] = useState("");
    let userInfo = JSON.parse(localStorage.getItem('userInfo-casier'));

    if (userInfo.poste !== "admin") {
        localStorage.removeItem("accessToken-casier");
        localStorage.removeItem('userInfo-casier');
        navigate('/login'); 
    }

    return (
        <>
            <div className="d-flex justify-content-center align-items-center mt-3 mb-3">
                <div className="row justify-content-center px-2 px-md-5">
                    <Row>
                        <AlertInfo type="primary" />
                        <div className="rounded-top p-2 fade-in-box">
                            <h3 className="text-secondary fw-bolder">Enregistrement agents</h3> <hr />
                        </div>
                    </Row>
                    <Row className="justify-content-center p-0 mb-2 fade-in-box border">

                        <DataForm
                          url="/add_agent"
                          className="row px-2 py-4 justify-content-center bg-white"
                          submit="Enregistrer"
                          onSuccess={(data) => console.log("Partenaire ajouté", data)}
                          fields={[
                            {
                                name : "nom",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Nom"
                            },
                            {
                                name : "prenom",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Prénom"
                            },
                            {
                                name : "poste",
                                type : "select",
                                className : "shadow-none form-select rounded",
                                classFormGroup : classFormGroup,
                                options : [
                                    {value : "admin", label : "Admin"},
                                    {value : "greffier", label : "greffier"},
                                    {value : "magistrat", label : "magistrat"}
                                ],
                                firstValSelect : "Poste",
                            },
                            {
                                name : "login",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Login"
                            },
                            {
                                name : "mdp",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Mot de passe"
                            },
                            
                          ]}

                        />

                    </Row>
                    
                    <Row className="bg-white fade-in-box border">
                        <FormSerch search={search} setSearch={setSearch} classSerch={"my-2 col-md-5 rounded-0"} />
                        <hr />
                        <Col className="row justify-content-center" lg="12" id="debut">
                          {
                            search.trim() === "" ?
                          
                            <TableData
                                url="/get_agent"
                                typeReturn="Table"
                                headerItem={['N°', 'Nom', 'Prénom', 'Postes', 'Login', 'Action']}
                                renderRow={(agent, index) => (
                                    <tr key={index}>
                                        <td>{agent.id}</td>
                                        <td className="text-uppercase text-start">{agent.nom}</td>
                                        <td className="text-uppercase text-start">{agent.prenom}</td>
                                        <td>{agent.poste}</td>
                                        <td>{agent.login}</td>
                                        <td><Button disabled as={Link} to={'/infoagent?name=' + agent.nom + '&c=' + agent.code} variant="warning" className="rounded-0" title={agent.code} size="sm">Voir plus</Button></td>
                                    </tr>
                                )}
                            /> :

                            <RechercheReq
                                url={"/search_agent"}
                                search={search}
                                headerItem={['N°', 'Nom', 'Prénom', 'Postes', 'Login', 'Action']}
                                renderRow={(agent, index) => (
                                    <tr key={index}>
                                        <td>{agent.id}</td>
                                        <td className="text-uppercase text-start">{agent.nom}</td>
                                        <td className="text-uppercase text-start">{agent.prenom}</td>
                                        <td>{agent.poste}</td>
                                        <td>{agent.login}</td>
                                        <td><Button disabled as={Link} to={'/infoagent?name=' + agent.nom + '&c=' + agent.code} variant="warning" className="rounded-0" title={agent.code} size="sm">Voir plus</Button></td>
                                    </tr>
                                )}
                            />
                           }  
                        </Col>
                    </Row>
                </div>
            </div>
        </>
    )
}


