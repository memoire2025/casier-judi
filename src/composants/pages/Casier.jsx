import { useState } from "react";
import { Row, Col, Button } from "react-bootstrap";
import { TableData, DataForm, RechercheReq, AlertInfo, FormSerch } from "../request/Request";
import { Link } from "react-router-dom";

export default function Casier () {
    const defautInputClass = "shadow-none rounded";
    const classFormGroup = "my-2 col-md-11";

    const [search, setSearch] = useState("");

    return (
        <>
            <div className="d-flex justify-content-center align-items-center mt-3 mb-3 fade-in-box">
                <div className="row justify-content-center px-2 px-md-5">
                    <Row>
                        <AlertInfo type="primary" />
                        <div className="rounded-top p-2">
                            <h3 className="text-secondary fw-bolder">Enregistrement casiers</h3> <hr />
                        </div>
                    </Row>
                    <Row className="justify-content-center p-0 mb-2 border">

                        <DataForm
                          url="/add_personne"
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
                                name : "postnom",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Post-nom"
                            },
                            {
                                name : "prenom",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Prénom"
                            },
                            {
                                label : "Date de naissance",
                                name : "date_naissance",
                                type : "date",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Date"
                            },
                            {
                                name : "lieu",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Lieu de naissance"
                            },
                            {
                                name : "nationalite",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Nationalité",
                                defaultVal : "Congolaise"
                            },
                            {
                                name : "sexe",
                                type : "select",
                                className : "shadow-none form-select rounded",
                                classFormGroup : classFormGroup,
                                options : [
                                    {value : "M", label : "M"},
                                    {value : "F", label : "F"},
                                ],
                                firstValSelect : "Sexe",
                            },
                            {
                                name : "num_identite",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Numéro d'identité"
                            },
                            {
                                name : "img",
                                type : "file",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                            },
                            
                          ]}

                        />

                    </Row>
                    
                    <Row className="bg-white border mt-2">
                        <FormSerch search={search} setSearch={setSearch} classSerch={"my-2 col-md-5 rounded-0"} />
                        <hr />
                        <Col className="row justify-content-center" lg="12" id="debut">
                          {
                            search.trim() === "" ?
                          
                            <TableData
                                url="/get_personne"
                                typeReturn="Table"
                                headerItem={['N°', 'Noms', 'sexe', 'Date naiss.', 'nationalité', 'Action']}
                                renderRow={(casier, index) => (
                                    <tr key={index}>
                                        <td>{casier.id}</td>
                                        <td className="text-uppercase text-start">{casier.nom} {casier.prenom}</td>
                                        <td>{casier.sexe}</td>
                                        <td>{casier.date_naissance}</td>
                                        <td>{casier.nationalite}</td>
                                        <td><Button as={Link} to={'/infocasier?name=' + casier.nom + '&c=' + casier.code} variant="warning" title={casier.code} size="sm">Voir plus</Button></td>
                                    </tr>
                                )}
                            /> :

                            <RechercheReq
                                url={"/search_personne"}
                                search={search}
                                headerItem={['N°', 'Noms', 'sexe', 'Date naiss.', 'nationalité', 'Action']}
                                renderRow={(casier, index) => (
                                    <tr key={index}>
                                        <td>{casier.id}</td>
                                        <td className="text-uppercase text-start">{casier.nom} {casier.prenom}</td>
                                        <td>{casier.sexe}</td>
                                        <td>{casier.date_naissance}</td>
                                        <td>{casier.nationalite}</td>
                                        <td><Button as={Link} to={'/infocasier?name=' + casier.nom + '&c=' + casier.code} variant="warning" size="sm">Voir plus</Button></td>
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


