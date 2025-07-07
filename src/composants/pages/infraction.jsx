import { useState } from "react";
import { Row, Col, Button } from "react-bootstrap";
import { TableData, DataForm, RechercheReq, AlertInfo, FormSerch } from "../request/Request";
import { Link, useLocation } from "react-router-dom";

export default function Infraction () {
    const defautInputClass = "shadow-none rounded";
    const classFormGroup = "my-2 col-md-11";

    const [search, setSearch] = useState("");

    const location = useLocation();
    const param = new URLSearchParams(location.search);
    const code_casier = param.get('code');
    const noms = param.get('name');

    return (
        <>
            <div className="d-flex justify-content-center align-items-center mt-3 mb-3 fade-in-box">
                <div className="row justify-content-center px-2 px-md-5">
                    

                    {/* <FormSerch search={search} setSearch={setSearch} classSerch={"my-2 col-md-5"} /> */}
                    
                    <Row className="bg-white border">
                        <Col className="row justify-content-center" lg="12" id="debut">
                          <h4 className="text-secondary fw-bolder">Infraction commit par {noms}</h4>
                          <hr />
                          {
                            search.trim() === "" ?
                          
                            <TableData
                                url="/get_personneIfraction"
                                code={code_casier}
                                typeReturn="Table"
                                headerItem={['N°', 'Type', 'Description', 'Date infract.', 'Lieu', 'Peine', 'Durée']}
                                renderRow={(infraction, index) => (
                                    <tr key={index}>
                                        <td>{infraction.id}</td>
                                        <td>{infraction.type_infraction}</td>
                                        <td>{infraction.description}</td>
                                        <td>{infraction.date_infraction}</td>
                                        <td>{infraction.lieu}</td>
                                        <td>{infraction.peine}</td>
                                        <td>{infraction.dure_pein}</td>
                                        {/* <td><Button as={Link} to={'/infoinfraction?name=' + infraction.nom + '&c=' + infraction.code} variant="warning" title={infraction.code} size="sm">Voir plus</Button></td> */}
                                    </tr>
                                )}
                            /> :

                            <RechercheReq
                                url={"/search_infraction_personne"}
                                search={search}
                                headerItem={['N°', 'Noms', 'sexe', 'Date naiss.', 'Lieu', 'Peine', 'Durée']}
                                renderRow={(infraction, index) => (
                                    <tr key={index}>
                                        <td>{infraction.id}</td>
                                        <td>{infraction.nom} {infraction.prenom}</td>
                                        <td>{infraction.sexe}</td>
                                        <td>{infraction.date_naissance}</td>
                                        <td>{infraction.nationalite}</td>
                                        <td><Button as={Link} to={'/infoinfraction?name=' + infraction.nom + '&c=' + infraction.code} variant="warning" size="sm">Voir plus</Button></td>
                                    </tr>
                                )}

                            />
                           }  
                        </Col>
                    </Row>

                    <Row className="my-2">
                        <AlertInfo type="primary" />
                        <div className="rounded-top p-2">
                            <h3 className="text-secondary fw-bolder">Ajout Infraction pour l'individu : {noms}</h3> <hr />
                        </div>
                    </Row>
                    <Row className="justify-content-center p-0 mb-2 border">

                        <DataForm
                          url="/add_infraction"
                          className="row px-2 py-4 justify-content-center bg-white"
                          submit="Enregistrer"
                          onSuccess={(data) => console.log("Partenaire ajouté", data)}
                          fields={[
                            {
                                name : "type_infraction",
                                type : "select",
                                className : "shadow-none form-select rounded",
                                classFormGroup : classFormGroup,
                                options : [
                                    {value : "contravention", label : "Contravention"},
                                    {value : "delit", label : "Délit"},
                                    {value : "crime", label : "Crime"},
                                    {value : "Harcelement", label : "Harcelement"},
                                    {value : "Vol simple", label : "Vol simple"},
                                    {value : "Meurtre", label : "Meutre"},
                                    {value : "infraction contre les personne", label : "Infraction contre les personne"},
                                    {value : "infraction contre les biens", label : "infraction contre les biens"},
                                    {value : "infraction contre l'ordre public", label : "infraction contre l'ordre public"},
                                ],
                                firstValSelect : "Types",
                            },
                            {
                                name : "description",
                                type : 'textarea',
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Déscription"
                            },
                            {
                                name : "date_infraction",
                                type : "date",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                label : "Date de l'infraction",
                                placeholder : "Date"
                            },
                            {
                                name : "lieu",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Lieu de l'infaction"
                            },
                            {
                                name : "peine",
                                type : "select",
                                className : "shadow-none form-select rounded",
                                classFormGroup : classFormGroup,
                                options : [
                                    {value : "peine privatives de liberté", label : "peine privatives de liberté"},
                                    {value : "peine pécuniaire", label : "peine pécuniaire"},
                                    {value : "Interdiction / Suspension", label : "Interdiction / Suspension"},
                                    {value : "confiscation", label : "Confiscation"},
                                    {value : "retrait de droit", label : "Retrait de droit"},
                                    {value : "Prison", label : "Prison"},
                                    {value : "Prison + amande", label : "Prison + Amande"},
                                    {value : "Prison + Stage + Interdiction de contact", label : "Prison + Stage + Interdiction de contact"},
                                ],
                                firstValSelect : "Peine",
                            },
                            {
                                name : "dure_pein",
                                className : defautInputClass,
                                classFormGroup : classFormGroup,
                                placeholder : "Durée de la  peine"
                            },
                            {
                                name : "code_casier",
                                type : "hidden",
                                defaultVal : code_casier,
                            },
                            
                          ]}

                        />

                    </Row>

                </div>
            </div>
        </>
    )
}


